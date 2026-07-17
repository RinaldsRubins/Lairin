<?php

namespace App\Http\Controllers\Concerns;

use App\Models\SeoPage;

trait LoadsSeoData
{
    protected function seoFor(string $path): ?SeoPage
    {
        return SeoPage::query()->where('path', $path)->first();
    }
}
