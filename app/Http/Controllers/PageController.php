<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function home()
    {
        $testimonials = Testimonial::query()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $featuredProducts = Product::query()
            ->active()
            ->latest()
            ->limit(4)
            ->get();

        return view('home', compact('testimonials', 'featuredProducts'));
    }

    public function about()
    {
        return view('about', [
            'stats' => config('damson.stats'),
        ]);
    }

    public function formsHub()
    {
        return view('forms.hub');
    }
}
