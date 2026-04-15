<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $seoTitle = trim($__env->yieldContent('title', 'KSB homes Design + Construct'));
        $seoDescription = trim($__env->yieldContent('meta_description', 'KSB homes - award-winning design, development, and construction for luxury residential projects.'));
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoRobots = trim($__env->yieldContent('meta_robots', 'index,follow'));
        $seoOgType = trim($__env->yieldContent('og_type', 'website'));
        $seoImage = trim($__env->yieldContent('og_image', asset('assets/images/hero-poster.jpg')));
        $seoSiteName = config('app.name', 'KSB homes');
        $seoSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => rtrim(config('app.url'), '/').'#organization',
                    'name' => 'KSB homes',
                    'url' => rtrim(config('app.url'), '/'),
                    'logo' => asset('favicon.svg'),
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => rtrim(config('app.url'), '/').'#website',
                    'url' => rtrim(config('app.url'), '/'),
                    'name' => 'KSB homes',
                    'publisher' => [
                        '@id' => rtrim(config('app.url'), '/').'#organization',
                    ],
                    'inLanguage' => str_replace('_', '-', app()->getLocale()),
                ],
            ],
        ];
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta property="og:site_name" content="{{ $seoSiteName }}">
    <meta property="og:type" content="{{ $seoOgType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script type="application/ld+json">{!! json_encode($seoSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @stack('styles')
</head>
<body class="page-body">
    @include('header')

    <main class="page-main" role="main">
        @yield('content')
    </main>

    @include('footer')

    <script>
        (function() {
            var toggle = document.getElementById('menu-toggle');
            var closeBtn = document.getElementById('menu-close');
            var overlay = document.getElementById('nav-overlay');
            var body = document.body;

            function openMenu() {
                body.classList.add('menu-open');
                if (overlay) overlay.classList.add('is-open');
                if (toggle) toggle.setAttribute('aria-expanded', 'true');
                if (overlay) overlay.setAttribute('aria-hidden', 'false');
            }

            function closeMenu() {
                body.classList.remove('menu-open');
                if (overlay) overlay.classList.remove('is-open');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
                if (overlay) overlay.setAttribute('aria-hidden', 'true');
            }

            if (toggle) toggle.addEventListener('click', openMenu);
            if (closeBtn) closeBtn.addEventListener('click', closeMenu);

            if (overlay) {
                overlay.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', closeMenu);
                });
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
