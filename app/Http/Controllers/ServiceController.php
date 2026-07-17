<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['services' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('sort_order')])
            ->get();

        return view('services.index', [
            'categories' => $categories,
            'seo' => $this->seoFor('/pakalpojumi'),
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        return view('services.show', [
            'service' => $service,
            'seo' => $this->seoFor("/pakalpojumi/{$slug}"),
        ]);
    }
}
