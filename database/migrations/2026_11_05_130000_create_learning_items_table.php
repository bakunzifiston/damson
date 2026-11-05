<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Combines blog posts, guides and library resources into one table.
 * The old tables are left untouched (nothing is dropped) so the data can be verified or rolled back.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 16)->index();            // article | guide | download
            $table->string('title');
            $table->string('slug');
            $table->string('excerpt', 500)->nullable();
            $table->longText('body')->nullable();           // articles and guides
            $table->string('category', 64)->nullable();     // downloads are grouped by this
            $table->string('difficulty', 32)->nullable();   // guides
            $table->string('format', 32)->nullable();       // downloads: pdf, video, infographic…
            $table->string('external_url')->nullable();     // downloads
            $table->string('file_path')->nullable();        // downloads
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['type', 'slug']);
        });

        if (Schema::hasTable('blog_posts')) {
            DB::table('blog_posts')->orderBy('id')->each(fn ($r) => DB::table('learning_items')->insert([
                'type' => 'article', 'title' => $r->title, 'slug' => $r->slug, 'excerpt' => $r->excerpt, 'body' => $r->body,
                'is_published' => $r->is_published, 'published_at' => $r->published_at,
                'created_at' => $r->created_at, 'updated_at' => $r->updated_at,
            ]));
        }

        if (Schema::hasTable('guides')) {
            DB::table('guides')->orderBy('id')->each(fn ($r) => DB::table('learning_items')->insert([
                'type' => 'guide', 'title' => $r->title, 'slug' => $r->slug, 'excerpt' => $r->excerpt, 'body' => $r->body,
                'difficulty' => $r->difficulty, 'sort_order' => $r->sort_order, 'is_published' => true,
                'created_at' => $r->created_at, 'updated_at' => $r->updated_at,
            ]));
        }

        if (Schema::hasTable('library_resources')) {
            $used = [];
            DB::table('library_resources')->orderBy('id')->each(function ($r) use (&$used) {
                $base = Str::slug($r->title) ?: 'resource';
                $slug = $base;
                for ($n = 1; isset($used[$slug]); $n++) {
                    $slug = $base.'-'.$n;
                }
                $used[$slug] = true;

                DB::table('learning_items')->insert([
                    'type' => 'download', 'title' => $r->title, 'slug' => $slug, 'excerpt' => $r->description,
                    'category' => $r->category, 'format' => $r->resource_type, 'external_url' => $r->external_url,
                    'file_path' => $r->file_path, 'is_published' => true,
                    'created_at' => $r->created_at, 'updated_at' => $r->updated_at,
                ]);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_items');
    }
};
