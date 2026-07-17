<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Industry;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        $serviceCategories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['services' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('sort_order')])
            ->get();

        $industries = Industry::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProjects = Project::query()
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('home.index', [
            'serviceCategories' => $serviceCategories,
            'industries' => $industries,
            'featuredProjects' => $featuredProjects,
            'testimonials' => $testimonials,
            'seo' => $this->seoFor('/'),
        ]);
    }
}
