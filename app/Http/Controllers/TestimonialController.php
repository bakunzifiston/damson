<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $stories = Testimonial::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $featuredStory = $stories->first();

        return view('success-stories', compact('stories', 'featuredStory'));
    }
}
