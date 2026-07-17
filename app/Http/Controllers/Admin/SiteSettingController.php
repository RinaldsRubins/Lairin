<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.id' => ['required', 'exists:site_settings,id'],
            'settings.*.value' => ['nullable', 'string'],
        ]);

        foreach ($validated['settings'] as $settingData) {
            SiteSetting::query()
                ->where('id', $settingData['id'])
                ->update(['value' => $settingData['value'] ?? '']);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Iestatījumi saglabāti.');
    }
}
