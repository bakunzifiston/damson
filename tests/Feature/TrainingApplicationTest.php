<?php

namespace Tests\Feature;

use App\Models\TrainingApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingApplicationTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $over = []): array
    {
        return array_merge([
            'full_name' => 'Jean Claude Uwimana',
            'phone' => '+250 785 171 213',
            'email' => 'jean@example.com',
            'district' => 'Rubavu / Rugerero',
            'training_mode' => 'on_site',
            'interests' => ['Beginner Mushroom Farming', 'Mushroom Spawn Production'],
            'experience' => 'basic',
            'start_preference' => 'asap',
            'objective' => 'I want to start my own mushroom farm.',
        ], $over);
    }

    private function application(array $over = []): TrainingApplication
    {
        return TrainingApplication::query()->create(array_merge($this->payload(), ['interests' => ['Beginner Mushroom Farming']], $over));
    }

    // ---------- public form ----------

    public function test_form_page_shows_every_field_and_option(): void
    {
        $this->get('/learning/apply')->assertOk()
            ->assertSee('Apply for Mushroom Farming Training')
            ->assertSee('Full name')->assertSee('Phone number (WhatsApp)')->assertSee('Email address')->assertSee('District / Sector of residence')
            ->assertSee('Online Training')->assertSee('On-Site Training (at DAMSON MUSHROOM FARM LTD)')
            ->assertSee('Commercial Mushroom Farming and Business Development')
            ->assertSee('I have basic knowledge')->assertSee('Within the next month')->assertSee('I am flexible to start this week')
            ->assertSee('main objective');
        foreach (TrainingApplication::INTERESTS as $interest) {
            $this->get('/learning/apply')->assertSee($interest);
        }
    }

    public function test_valid_submission_is_saved_with_all_fields_and_shows_success(): void
    {
        $this->post('/learning/apply', $this->payload())->assertRedirect('/learning/apply');

        $a = TrainingApplication::query()->firstOrFail();
        $this->assertSame('Jean Claude Uwimana', $a->full_name);
        $this->assertSame('+250 785 171 213', $a->phone);
        $this->assertSame('on_site', $a->training_mode);
        $this->assertSame(['Beginner Mushroom Farming', 'Mushroom Spawn Production'], $a->interests);   // multiple interests persisted
        $this->assertSame('basic', $a->experience);
        $this->assertSame('asap', $a->start_preference);
        $this->assertSame('new', $a->status);
        $this->assertNull($a->admin_notes);

        $this->followingRedirects()->post('/learning/apply', $this->payload(['email' => 'other@example.com']))->assertSee('Application received');
        // refreshing the page afterwards shows the form again, not the success card
        $this->get('/learning/apply')->assertDontSee('Application received')->assertSee('Submit application');
    }

    public function test_every_required_field_is_validated(): void
    {
        $this->post('/learning/apply', [])->assertSessionHasErrors(['full_name', 'phone', 'email', 'district', 'training_mode', 'interests', 'experience', 'start_preference', 'objective']);
        $this->assertSame(0, TrainingApplication::query()->count());
    }

    public function test_field_formats_and_allowed_values_are_enforced(): void
    {
        $this->post('/learning/apply', $this->payload(['email' => 'not-an-email']))->assertSessionHasErrors('email');
        $this->post('/learning/apply', $this->payload(['phone' => 'call me']))->assertSessionHasErrors('phone');
        $this->post('/learning/apply', $this->payload(['phone' => '123']))->assertSessionHasErrors('phone');
        $this->post('/learning/apply', $this->payload(['training_mode' => 'hybrid']))->assertSessionHasErrors('training_mode');
        $this->post('/learning/apply', $this->payload(['interests' => []]))->assertSessionHasErrors('interests');
        $this->post('/learning/apply', $this->payload(['interests' => ['Hacking']]))->assertSessionHasErrors('interests.0');
        $this->post('/learning/apply', $this->payload(['experience' => 'expert']))->assertSessionHasErrors('experience');
        $this->post('/learning/apply', $this->payload(['start_preference' => 'never']))->assertSessionHasErrors('start_preference');
        $this->post('/learning/apply', $this->payload(['objective' => 'short']))->assertSessionHasErrors('objective');
        $this->post('/learning/apply', $this->payload(['objective' => str_repeat('x', 2001)]))->assertSessionHasErrors('objective');
        $this->assertSame(0, TrainingApplication::query()->count());
    }

    public function test_validation_messages_are_shown_on_the_form(): void
    {
        $this->from('/learning/apply')->followingRedirects()->post('/learning/apply', ['full_name' => ''])
            ->assertSee('Select at least one area you are interested in.')->assertSee('The full name field is required.');
    }

    public function test_double_submit_does_not_create_duplicates(): void
    {
        $this->post('/learning/apply', $this->payload());
        $this->post('/learning/apply', $this->payload());
        $this->assertSame(1, TrainingApplication::query()->count());

        // a different person (different email) is still accepted
        $this->post('/learning/apply', $this->payload(['email' => 'other@example.com']));
        $this->assertSame(2, TrainingApplication::query()->count());

        // the same person can apply again later
        $this->travel(11)->minutes();
        $this->post('/learning/apply', $this->payload());
        $this->assertSame(3, TrainingApplication::query()->count());
    }

    public function test_honeypot_submissions_are_silently_dropped(): void
    {
        $this->post('/learning/apply', $this->payload(['website' => 'http://spam.example']))->assertRedirect('/learning/apply');
        $this->assertSame(0, TrainingApplication::query()->count());
    }

    public function test_submission_is_rate_limited(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->post('/learning/apply', $this->payload(['email' => "p{$i}@example.com"]));
        }
        $this->post('/learning/apply', $this->payload(['email' => 'late@example.com']))->assertStatus(429);
    }

    public function test_script_in_text_fields_is_stored_as_text_and_escaped_in_admin(): void
    {
        $this->post('/learning/apply', $this->payload(['full_name' => '<script>alert(1)</script>']));
        $a = TrainingApplication::query()->firstOrFail();

        $this->actingAs(User::factory()->create());
        $this->get("/data-hub/training/{$a->id}")->assertOk()->assertDontSee('<script>alert(1)</script>', false);
    }

    // ---------- admin ----------

    public function test_guests_cannot_see_or_change_applications(): void
    {
        $a = $this->application();

        $this->get('/data-hub/training')->assertRedirect('/login');
        $this->get("/data-hub/training/{$a->id}")->assertRedirect('/login');
        $this->put("/data-hub/training/{$a->id}", ['status' => 'accepted'])->assertRedirect('/login');
        $this->assertSame('new', $a->fresh()->status);
    }

    public function test_staff_can_list_search_filter_and_open_applications(): void
    {
        $this->application(['full_name' => 'Alice Mukamana', 'phone' => '+250 788 000 111', 'email' => 'alice@example.com', 'training_mode' => 'online', 'interests' => ['Mushroom Spawn Production']]);
        $this->application(['full_name' => 'Bob Habimana', 'phone' => '+250 722 999 222', 'email' => 'bob@example.com', 'training_mode' => 'on_site', 'interests' => ['Beginner Mushroom Farming', 'Mushroom Farming, Tube Production and DMMS'], 'status' => 'contacted']);
        $this->actingAs(User::factory()->create());

        $this->get('/data-hub/training')->assertOk()->assertSee('Alice Mukamana')->assertSee('Bob Habimana');

        // search by name, phone and email
        $this->get('/data-hub/training?q=alice')->assertSee('Alice Mukamana')->assertDontSee('Bob Habimana');
        $this->get('/data-hub/training?q=722 999')->assertSee('Bob Habimana')->assertDontSee('Alice Mukamana');
        $this->get('/data-hub/training?q=bob@example')->assertSee('Bob Habimana')->assertDontSee('Alice Mukamana');

        // filter by mode, interest (multi-value column) and status
        $this->get('/data-hub/training?mode=online')->assertSee('Alice Mukamana')->assertDontSee('Bob Habimana');
        $this->get('/data-hub/training?interest='.urlencode('Mushroom Spawn Production'))->assertSee('Alice Mukamana')->assertDontSee('Bob Habimana');
        $this->get('/data-hub/training?interest='.urlencode('Mushroom Farming, Tube Production and DMMS'))->assertSee('Bob Habimana')->assertDontSee('Alice Mukamana');
        $this->get('/data-hub/training?status=contacted')->assertSee('Bob Habimana')->assertDontSee('Alice Mukamana');
        $this->get('/data-hub/training?mode=online&status=contacted')->assertDontSee('Alice Mukamana')->assertDontSee('Bob Habimana');

        // sorting with a bad column falls back safely
        $this->get('/data-hub/training?sort=full_name&dir=asc')->assertOk()->assertSeeInOrder(['Alice Mukamana', 'Bob Habimana']);
        $this->get('/data-hub/training?sort=password')->assertOk();
    }

    public function test_staff_can_view_details_update_status_and_add_notes(): void
    {
        $a = $this->application(['objective' => "Line one\nLine two", 'interests' => ['Beginner Mushroom Farming', 'Mushroom Spawn Production']]);
        $this->actingAs(User::factory()->create());

        $this->get("/data-hub/training/{$a->id}")->assertOk()
            ->assertSee($a->full_name)->assertSee($a->email)->assertSee('Rubavu / Rugerero')
            ->assertSee('On-Site Training')->assertSee('Beginner Mushroom Farming')->assertSee('Mushroom Spawn Production')
            ->assertSee('I have basic knowledge')->assertSee('As soon as possible')->assertSee('Line one')
            ->assertSee('Submitted');

        $this->put("/data-hub/training/{$a->id}", ['status' => 'bogus'])->assertSessionHasErrors('status');

        $this->put("/data-hub/training/{$a->id}", ['status' => 'accepted', 'admin_notes' => 'Called on Monday, starts next cohort.'])
            ->assertRedirect("/data-hub/training/{$a->id}");
        $a->refresh();
        $this->assertSame('accepted', $a->status);
        $this->assertSame('Called on Monday, starts next cohort.', $a->admin_notes);

        $this->get('/data-hub/training?status=accepted')->assertSee($a->full_name);
        $this->get("/data-hub/training/{$a->id}")->assertSee('Called on Monday');
        // the application itself is untouched by a status update
        $this->assertSame('Line one'."\n".'Line two', $a->objective);
    }

    public function test_internal_notes_never_appear_publicly(): void
    {
        $this->application(['admin_notes' => 'SECRET-STAFF-NOTE']);

        foreach (['/learning/apply', '/learning', '/learning/resources'] as $url) {
            $this->get($url)->assertDontSee('SECRET-STAFF-NOTE');
        }
    }

    public function test_dashboard_overview_counts_new_applications_and_nav_links_work(): void
    {
        $this->application();
        $this->application(['email' => 'b@example.com', 'status' => 'accepted']);
        $this->actingAs(User::factory()->create());

        $this->get('/data-hub')->assertOk()->assertViewHas('trainingTotal', 2)->assertViewHas('trainingNew', 1)
            ->assertSee('Training applications (1 new)')->assertSee('/data-hub/training');
    }

    public function test_learning_enroll_buttons_point_to_the_application_form(): void
    {
        $this->get('/learning')->assertOk()->assertSee('/learning/apply')->assertDontSee('Training%20enrollment', false);
    }

    public function test_learning_banner_has_a_quick_apply_button_and_other_banners_do_not(): void
    {
        $html = $this->get('/learning')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('#<a href="[^"]*/learning/apply" class="damson-btn-accent px-7 py-3[^"]*">Apply now#', $html);

        $this->get('/about')->assertOk()->assertDontSee('Apply now');
    }
}
