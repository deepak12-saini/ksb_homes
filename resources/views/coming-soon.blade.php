<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Coming Soon — {{ config('app.name', 'KSB homes') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: "Inter", system-ui, sans-serif;
            background: #0a0a0a;
            color: #e5e5e5;
            -webkit-font-smoothing: antialiased;
        }
        .wrap {
            text-align: center;
            max-width: 28rem;
        }
        .logo {
            display: block;
            margin: 0 auto 2.5rem;
            max-width: 200px;
            height: auto;
        }
        .logo-fallback {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
            color: #fff;
        }
        h1 {
            font-size: clamp(1.75rem, 5vw, 2.25rem);
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin: 0 0 1.25rem;
            color: #fff;
        }
        p {
            margin: 0;
            font-size: 0.9375rem;
            line-height: 1.65;
            color: #a3a3a3;
        }
    </style>
</head>
<body>
    <div class="wrap">
        @if (file_exists(public_path('assets/images/ksb_logo.svg')))
            <img src="{{ asset('assets/images/ksb_logo.svg') }}" alt="{{ config('app.name') }}" class="logo" width="200" height="80">
        @else
            <p class="logo-fallback">{{ config('app.name', 'KSB homes') }}</p>
        @endif
        <h1>Coming Soon</h1>
        <p>We are currently working on our offline profile</p>
    </div>
</body>
</html>
