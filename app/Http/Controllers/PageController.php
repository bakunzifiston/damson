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

        $latestProducts = Product::query()
            ->active()
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('testimonials', 'latestProducts'));
    }

    public function about()
    {
        return view('about');
    }

    public function formsHub()
    {
        return view('forms.hub');
    }
}
