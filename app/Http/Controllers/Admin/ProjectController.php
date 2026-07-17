<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProject($request);

        Project::query()->create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projekts izveidots.');
    }

    public function show(Project $project): View
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validateProject($request);

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projekts atjaunināts.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projekts dzēsts.');
    }

    protected function validateProject(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'client' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:500'],
            'gallery' => ['nullable', 'array'],
            'technologies' => ['nullable', 'array'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
