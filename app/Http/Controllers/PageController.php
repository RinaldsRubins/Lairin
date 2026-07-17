<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\View\View;

class PageController extends Controller
{
    use LoadsSeoData;

    public function about(): View
    {
        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.about', [
            'testimonials' => $testimonials,
            'seo' => $this->seoFor('/par-mums'),
        ]);
    }

    public function faq(): View
    {
        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn (Faq $faq) => $faq->category ?? 'Vispārīgi');

        return view('pages.faq', [
            'faqs' => $faqs,
            'seo' => $this->seoFor('/buj'),
        ]);
    }
}
