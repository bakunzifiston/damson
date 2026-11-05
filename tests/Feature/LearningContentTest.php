<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\LearningItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LearningContentTest extends TestCase
{
    use RefreshDatabase;

    private function staff(): void
    {
        $this->actingAs(User::factory()->create());
    }

    private function item(array $attrs = []): LearningItem
    {
        return LearningItem::query()->create($attrs + ['type' => 'article', 'title' => 'T', 'slug' => 't-'.uniqid(), 'body' => 'b', 'is_published' => true]);
    }

    public function test_guests_cannot_reach_resource_or_faq_management(): void
    {
        $item = $this->item();
        $faq = Faq::query()->create(['question' => 'Q', 'answer' => 'A']);

        foreach ([['get', '/data-hub/resources'], ['get', '/data-hub/resources/create'], ['post', '/data-hub/resources'],
            ['get', "/data-hub/resources/{$item->id}/edit"], ['put', "/data-hub/resources/{$item->id}"], ['delete', "/data-hub/resources/{$item->id}"],
            ['get', '/data-hub/faqs'], ['post', '/data-hub/faqs'], ['delete', "/data-hub/faqs/{$faq->id}"]] as [$m, $u]) {
            $this->{$m}($u)->assertRedirect('/login');
        }
        $this->assertDatabaseHas('learning_items', ['id' => $item->id]);
        $this->assertDatabaseHas('faqs', ['id' => $faq->id]);
    }

    public function test_article_crud_slug_and_publishing(): void
    {
        $this->staff();

        $this->post('/data-hub/resources', ['type' => 'article'])->assertSessionHasErrors(['title', 'body']);
        $this->post('/data-hub/resources', ['type' => 'bogus', 'title' => 'x'])->assertSessionHasErrors('type');
        $this->post('/data-hub/resources', ['type' => 'article', 'title' => 'Bad', 'body' => 'x', 'slug' => 'Bad Slug!'])->assertSessionHasErrors('slug');

        $this->post('/data-hub/resources', ['type' => 'article', 'title' => 'Growing Oysters', 'body' => '# Hi', 'is_published' => 1])
            ->assertRedirect('/data-hub/resources?type=article');
        $post = LearningItem::query()->firstOrFail();
        $this->assertSame('growing-oysters', $post->slug);
        $this->assertNotNull($post->published_at);
        $this->get('/learning/blog/growing-oysters')->assertOk()->assertSee('Growing Oysters');

        $this->post('/data-hub/resources', ['type' => 'article', 'title' => 'Growing Oysters', 'body' => 'x']);
        $this->assertSame('growing-oysters-1', LearningItem::query()->latest('id')->first()->slug);

        // editing the title keeps the public URL stable; the article body is saved
        $this->put("/data-hub/resources/{$post->id}", ['type' => 'article', 'title' => 'Growing Oysters 2', 'slug' => 'growing-oysters', 'body' => 'new', 'is_published' => 1])->assertRedirect();
        $this->assertSame('growing-oysters', $post->fresh()->slug);
        $this->assertSame('new', $post->fresh()->body);

        // draft => hidden publicly
        $this->put("/data-hub/resources/{$post->id}", ['type' => 'article', 'title' => 'Growing Oysters 2', 'body' => 'b']);
        $this->assertFalse($post->fresh()->is_published);
        $this->get('/learning/blog/growing-oysters')->assertNotFound();
        $this->get('/data-hub/resources?q=Oysters')->assertOk()->assertSee('Draft');
        $this->get("/data-hub/resources/{$post->id}/edit")->assertOk();

        $this->delete("/data-hub/resources/{$post->id}")->assertRedirect();
        $this->assertDatabaseMissing('learning_items', ['id' => $post->id]);
    }

    public function test_scheduled_article_is_hidden_until_its_date(): void
    {
        $this->staff();
        $this->post('/data-hub/resources', ['type' => 'article', 'title' => 'Later', 'body' => 'b', 'is_published' => 1, 'published_at' => now()->addDays(3)->format('Y-m-d\TH:i')]);

        $this->get('/learning/blog/later')->assertNotFound();
        $this->get('/learning/resources')->assertDontSee('Later');
        $this->get('/data-hub/resources')->assertSee('Scheduled');
    }

    public function test_guide_rules_and_same_slug_allowed_across_types(): void
    {
        $this->staff();

        $this->post('/data-hub/resources', ['type' => 'guide', 'title' => 'G', 'body' => 'b'])->assertSessionHasErrors('difficulty');
        $this->post('/data-hub/resources', ['type' => 'guide', 'title' => 'Spawn Run', 'body' => 'b', 'difficulty' => 'expert'])->assertSessionHasErrors('difficulty');
        $this->post('/data-hub/resources', ['type' => 'guide', 'title' => 'Spawn Run', 'body' => 'b', 'difficulty' => 'beginner', 'sort_order' => 2, 'is_published' => 1])->assertRedirect();
        $this->post('/data-hub/resources', ['type' => 'article', 'title' => 'Spawn Run', 'body' => 'b', 'is_published' => 1])->assertRedirect();

        $this->assertSame(['spawn-run', 'spawn-run'], LearningItem::query()->orderBy('id')->pluck('slug')->all());
        $this->get('/learning/guides/spawn-run')->assertOk();
        $this->get('/learning/blog/spawn-run')->assertOk();
        // an article is not reachable through the guide URL and vice versa
        LearningItem::query()->where('type', 'guide')->delete();
        $this->get('/learning/guides/spawn-run')->assertNotFound();
    }

    public function test_changing_type_clears_fields_of_the_old_type(): void
    {
        $this->staff();
        $guide = $this->item(['type' => 'guide', 'difficulty' => 'advanced', 'slug' => 'x']);

        $this->put("/data-hub/resources/{$guide->id}", ['type' => 'download', 'title' => 'Now a file', 'category' => 'Docs', 'format' => 'pdf', 'external_url' => 'https://example.com/a'])->assertRedirect();
        $guide->refresh();
        $this->assertSame('download', $guide->type);
        $this->assertNull($guide->difficulty);
        $this->assertNull($guide->body);
    }

    public function test_download_upload_replace_remove_and_delete_manage_files(): void
    {
        Storage::fake('public');
        $this->staff();
        $base = ['type' => 'download', 'title' => 'Manual', 'category' => 'Guides', 'format' => 'pdf', 'is_published' => 1];

        $this->post('/data-hub/resources', ['type' => 'download', 'title' => 'X'])->assertSessionHasErrors(['category', 'format']);
        $this->post('/data-hub/resources', $base + ['external_url' => 'javascript:alert(1)'])->assertSessionHasErrors('external_url');
        $this->post('/data-hub/resources', $base + ['file' => UploadedFile::fake()->create('evil.php', 5)])->assertSessionHasErrors('file');

        $this->post('/data-hub/resources', $base + ['file' => UploadedFile::fake()->create('m.pdf', 50, 'application/pdf')])->assertRedirect();
        $res = LearningItem::query()->firstOrFail();
        Storage::disk('public')->assertExists($res->file_path);
        $this->get('/learning/resources?type=download')->assertSee('Manual')->assertSee('Download');

        $old = $res->file_path;
        $this->put("/data-hub/resources/{$res->id}", $base + ['file' => UploadedFile::fake()->create('n.pdf', 50, 'application/pdf')]);
        $res->refresh();
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($res->file_path);

        $path = $res->file_path;
        $this->put("/data-hub/resources/{$res->id}", $base + ['remove_file' => 1]);
        $this->assertNull($res->fresh()->file_path);
        Storage::disk('public')->assertMissing($path);

        $this->put("/data-hub/resources/{$res->id}", $base + ['format' => 'link', 'external_url' => 'https://example.com/x']);
        $this->get('/learning/resources')->assertSee('https://example.com/x');

        $this->delete("/data-hub/resources/{$res->id}")->assertRedirect();
        $this->assertSame(0, LearningItem::query()->count());
    }

    public function test_public_resources_page_filters_searches_and_old_urls_redirect(): void
    {
        $this->item(['title' => 'Alpha article']);
        $this->item(['type' => 'guide', 'title' => 'Beta guide', 'difficulty' => 'beginner', 'slug' => 'beta']);
        $this->item(['type' => 'download', 'title' => 'Gamma file', 'category' => 'Docs', 'format' => 'pdf', 'external_url' => 'https://example.com', 'slug' => 'gamma']);
        $this->item(['title' => 'Hidden draft', 'is_published' => false]);

        $this->get('/learning/resources')->assertOk()->assertSee('Alpha article')->assertSee('Beta guide')->assertSee('Gamma file')->assertDontSee('Hidden draft');
        $this->get('/learning/resources?type=guide')->assertSee('Beta guide')->assertDontSee('Alpha article');
        $this->get('/learning/resources?q=gamma')->assertSee('Gamma file')->assertDontSee('Beta guide');
        $this->get('/learning/resources?q=%25')->assertOk()->assertDontSee('Alpha article');

        $this->get('/learning/blog')->assertRedirect('/learning/resources?type=article')->assertStatus(301);
        $this->get('/learning/guides')->assertRedirect('/learning/resources?type=guide');
        $this->get('/learning/library')->assertRedirect('/learning/resources?type=download');
    }

    public function test_faq_crud_and_public_filter(): void
    {
        $this->staff();

        $this->post('/data-hub/faqs', ['question' => ''])->assertSessionHasErrors(['question', 'answer']);
        $this->post('/data-hub/faqs', ['question' => 'Q?', 'answer' => 'A.', 'category' => 'Farming'])->assertRedirect('/data-hub/faqs');
        $faq = Faq::query()->firstOrFail();
        $this->assertSame(0, $faq->sort_order);
        $this->get('/learning/faqs?category=Farming')->assertSee('Q?');
        $this->put("/data-hub/faqs/{$faq->id}", ['question' => 'Q2?', 'answer' => 'A.'])->assertRedirect();
        $this->get('/data-hub/faqs?q=Q2')->assertOk()->assertSee('Q2?');
        $this->get("/data-hub/faqs/{$faq->id}/edit")->assertOk();
        $this->delete("/data-hub/faqs/{$faq->id}");
        $this->assertSame(0, Faq::query()->count());
    }

    public function test_markdown_html_is_stripped_on_public_pages(): void
    {
        $this->item(['slug' => 'safe', 'body' => "Hello\n\n<script>alert(1)</script>\n\n[x](javascript:alert(2))"]);

        $this->get('/learning/blog/safe')->assertOk()->assertDontSee('<script>alert(1)</script>', false)->assertDontSee('javascript:alert(2)', false);
    }

    public function test_every_content_page_renders(): void
    {
        $this->staff();
        $i = $this->item();
        foreach (['/data-hub/resources', '/data-hub/resources?type=guide', '/data-hub/resources/create', '/data-hub/resources/create?type=download', "/data-hub/resources/{$i->id}/edit",
            '/data-hub/faqs', '/data-hub/faqs/create', '/learning', '/learning/resources', '/learning/faqs', "/learning/blog/{$i->slug}"] as $u) {
            $this->get($u)->assertOk();
        }
    }
}
