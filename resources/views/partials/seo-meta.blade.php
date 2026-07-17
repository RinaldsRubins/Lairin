@php
    $defaultTitle = config('lairin.company.name').' — IT risinājumi Latvijā';
    $defaultDescription = config('lairin.site_description');
    $defaultKeywords = config('lairin.seo.default_keywords');
    $defaultOgImage = config('lairin.default_og_image');

    $rawTitle = ($seo->title ?? null) ?: (trim($__env->yieldContent('title')) ?: $defaultTitle);
    $metaTitle = str_contains($rawTitle, 'Lairin') ? $rawTitle : $rawTitle.' | Lairin';
    $metaDescription = ($seo->description ?? null) ?: (trim($__env->yieldContent('meta_description')) ?: $defaultDescription);
    $metaKeywords = ($seo->keywords ?? null) ?: (trim($__env->yieldContent('meta_keywords')) ?: $defaultKeywords);
    $ogImage = ($seo->og_image ?? null) ?: (trim($__env->yieldContent('og_image')) ?: $defaultOgImage);
    $ogImageUrl = str_starts_with($ogImage, 'http') ? $ogImage : asset($ogImage);
    $canonicalUrl = url()->current();
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="{{ config('lairin.company.name') }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Ģeogrāfiskā mērķēšana — Latvija --}}
<meta name="geo.region" content="{{ config('lairin.seo.geo_region') }}">
<meta name="geo.placename" content="{{ config('lairin.seo.geo_placename') }}">
<meta name="language" content="{{ config('lairin.seo.language') }}">
<meta http-equiv="content-language" content="lv">

{{-- Favicon & app icons --}}
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#0F172A">
<meta name="msapplication-TileColor" content="#0F172A">

{{-- Open Graph (Facebook, LinkedIn, WhatsApp preview) --}}
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ config('lairin.company.name') }}">
<meta property="og:locale" content="lv_LV">
<meta property="og:image" content="{{ $ogImageUrl }}">
<meta property="og:image:secure_url" content="{{ $ogImageUrl }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ config('lairin.company.name') }} — IT risinājumi Latvijā">
<meta property="og:image:type" content="image/png">

{{-- Twitter / X card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImageUrl }}">
<meta name="twitter:image:alt" content="{{ config('lairin.company.name') }} logo">

@if(config('services.google.search_console_verification'))
<meta name="google-site-verification" content="{{ config('services.google.search_console_verification') }}">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
