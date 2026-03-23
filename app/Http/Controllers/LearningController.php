<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Guide;
use App\Models\LibraryResource;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index()
    {
        return view('learning.index');
    }

    public function blogIndex()
    {
        $posts = BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9);

        return view('learning.blog.index', compact('posts'));
    }

    public function blogShow(BlogPost $post)
    {
        abort_unless($post->is_published && ($post->published_at === null || $post->published_at->lte(now())), 404);

        return view('learning.blog.show', compact('post'));
    }

    public function guides()
    {
        $guides = Guide::query()->orderBy('sort_order')->orderBy('title')->get();

        return view('learning.guides.index', compact('guides'));
    }

    public function guideShow(Guide $guide)
    {
        return view('learning.guides.show', compact('guide'));
    }

    public function faqs(Request $request)
    {
        $category = $request->query('category');

        $faqs = Faq::query()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $categories = Faq::query()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('learning.faqs', compact('faqs', 'categories', 'category'));
    }

    public function library()
    {
        $resources = LibraryResource::query()
            ->orderBy('category')
            ->orderBy('title')
            ->get()
            ->groupBy('category');

        return view('learning.library', compact('resources'));
    }
}
