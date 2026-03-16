<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KSB homes Design + Construct')</title>
    <meta name="description" content="@yield('meta_description', 'Award-winning design, development, and construction company specialising in luxury residential projects in Brisbane, Gold Coast and Byron Bay.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
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
