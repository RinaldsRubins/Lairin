<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $pages = SeoPage::query()
            ->orderBy('path')
            ->get();

        return view('admin.seo.index', compact('pages'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pages' => ['required', 'array'],
            'pages.*.id' => ['required', 'exists:seo_pages,id'],
            'pages.*.title' => ['nullable', 'string', 'max:255'],
            'pages.*.description' => ['nullable', 'string', 'max:500'],
            'pages.*.keywords' => ['nullable', 'string', 'max:500'],
            'pages.*.og_image' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($validated['pages'] as $pageData) {
            SeoPage::query()
                ->where('id', $pageData['id'])
                ->update([
                    'title' => $pageData['title'] ?? null,
                    'description' => $pageData['description'] ?? null,
                    'keywords' => $pageData['keywords'] ?? null,
                    'og_image' => $pageData['og_image'] ?? null,
                ]);
        }

        return redirect()
            ->route('admin.seo.index')
            ->with('success', 'SEO dati atjaunināti.');
    }
}
