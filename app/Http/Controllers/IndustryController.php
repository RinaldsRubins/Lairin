<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Industry;
use Illuminate\View\View;

class IndustryController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        $industries = Industry::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('industries.index', [
            'industries' => $industries,
            'seo' => $this->seoFor('/nozares'),
        ]);
    }
}
