<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use LoadsSeoData;

    public function index(Request $request): View
    {
        $query = Project::query()
            ->where('is_published', true)
            ->orderBy('sort_order');

        if ($request->filled('industry')) {
            $query->where('industry', $request->string('industry'));
        }

        $projects = $query->get();

        $industries = Project::query()
            ->where('is_published', true)
            ->whereNotNull('industry')
            ->distinct()
            ->orderBy('industry')
            ->pluck('industry');

        return view('projects.index', [
            'projects' => $projects,
            'industries' => $industries,
            'activeIndustry' => $request->string('industry')->toString(),
            'seo' => $this->seoFor('/projekti'),
        ]);
    }

    public function show(string $slug): View
    {
        $project = Project::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedProjects = Project::query()
            ->where('is_published', true)
            ->where('id', '!=', $project->id)
            ->when($project->industry, fn ($query) => $query->where('industry', $project->industry))
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'seo' => $this->seoFor("/projekti/{$slug}"),
        ]);
    }
}
