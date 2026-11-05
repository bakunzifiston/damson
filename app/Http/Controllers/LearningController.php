<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\LearningItem;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('learning.index', compact('testimonials'));
    }

    /** Combined list of articles, guides and downloads with a type filter and search. */
    public function resources(Request $request)
    {
        $type = array_key_exists($request->query('type'), LearningItem::TYPES) ? $request->query('type') : null;

        $query = LearningItem::query()->published();
        if ($type) {
            $query->ofType($type);
        }

        $term = trim((string) $request->query('q'));
        if ($term !== '') {
            $like = '%'.str_replace(['!', '%', '_'], ['!!', '!%', '!_'], mb_substr($term, 0, 100)).'%';
            $query->where(fn ($q) => $q
                ->whereRaw("title LIKE ? ESCAPE '!'", [$like])
                ->orWhereRaw("excerpt LIKE ? ESCAPE '!'", [$like])
                ->orWhereRaw("category LIKE ? ESCAPE '!'", [$like]));
        }

        match ($type) {
            LearningItem::TYPE_GUIDE => $query->orderBy('sort_order')->orderBy('title'),
            LearningItem::TYPE_DOWNLOAD => $query->orderBy('category')->orderBy('title'),
            default => $query->orderByRaw('COALESCE(published_at, created_at) DESC')->orderByDesc('id'),
        };

        return view('learning.resources', [
            'items' => $query->paginate(12)->withQueryString(),
            'type' => $type,
            'term' => $term,
            'counts' => LearningItem::query()->published()->selectRaw('type, COUNT(*) as n')->groupBy('type')->pluck('n', 'type'),
        ]);
    }

    public function articleShow(string $slug)
    {
        $post = LearningItem::query()->ofType(LearningItem::TYPE_ARTICLE)->where('slug', $slug)->firstOrFail();
        abort_unless($post->isVisible(), 404);

        return view('learning.blog.show', compact('post'));
    }

    public function guideShow(string $slug)
    {
        $guide = LearningItem::query()->ofType(LearningItem::TYPE_GUIDE)->where('slug', $slug)->firstOrFail();
        abort_unless($guide->isVisible(), 404);

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
}
