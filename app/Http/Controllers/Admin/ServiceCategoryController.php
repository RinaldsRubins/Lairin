<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.service-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.service-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);

        ServiceCategory::query()->create($validated);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategorija izveidota.');
    }

    public function show(ServiceCategory $serviceCategory): View
    {
        $serviceCategory->load(['services' => fn ($query) => $query->orderBy('sort_order')]);

        return view('admin.service-categories.show', ['category' => $serviceCategory]);
    }

    public function edit(ServiceCategory $serviceCategory): View
    {
        return view('admin.service-categories.edit', ['category' => $serviceCategory]);
    }

    public function update(Request $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $validated = $this->validateCategory($request);

        $serviceCategory->update($validated);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategorija atjaunināta.');
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        $serviceCategory->delete();

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategorija dzēsta.');
    }

    protected function validateCategory(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
