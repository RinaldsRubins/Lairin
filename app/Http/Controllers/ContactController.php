<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use Illuminate\View\View;

class ContactController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        return view('contact.index', [
            'company' => config('lairin.company'),
            'seo' => $this->seoFor('/kontakti'),
        ]);
    }
}
