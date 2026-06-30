<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Coming Soon — KSB Luxury Homes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #050505;
            --white: #f8f8f6;
            --muted: rgba(255, 255, 255, 0.62);
            --gold: #c9a962;
            --gold-soft: rgba(201, 169, 98, 0.35);
            --font-heading: "Cormorant Garamond", "Times New Roman", serif;
            --font-body: "Inter", system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
            background: var(--black);
            color: var(--white);
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        .cs {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            display: grid;
            place-items: center;
            padding: clamp(1.5rem, 4vw, 3rem);
            isolation: isolate;
        }

        /* Background slideshow */
        .cs__bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .cs__slide {
            position: absolute;
            inset: -8%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.08);
            animation: csKenBurns 18s ease-in-out infinite;
            will-change: transform, opacity;
        }

        .cs__slide:nth-child(1) {
            background-image: url("{{ asset('assets/images/residence-89.jpeg') }}");
            animation-delay: 0s;
        }

        .cs__slide:nth-child(2) {
            background-image: url("{{ asset('assets/images/darri-21.jpeg') }}");
            animation-delay: 6s;
        }

        .cs__slide:nth-child(3) {
            background-image: url("https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920&h=1080&fit=crop&q=80");
            animation-delay: 12s;
        }

        @keyframes csKenBurns {
            0%, 28% { opacity: 0; transform: scale(1.12); }
            5%, 23% { opacity: 1; transform: scale(1.02); }
            33%, 100% { opacity: 0; transform: scale(1.18); }
        }

        .cs__overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background:
                radial-gradient(ellipse 80% 60% at 50% 40%, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.82) 70%),
                linear-gradient(180deg, rgba(5, 5, 5, 0.55) 0%, rgba(5, 5, 5, 0.35) 45%, rgba(5, 5, 5, 0.92) 100%);
            pointer-events: none;
        }

        .cs__grain {
            position: fixed;
            inset: 0;
            z-index: 2;
            opacity: 0.045;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* Floating accent orbs */
        .cs__orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 2;
            opacity: 0.5;
            animation: csFloat 12s ease-in-out infinite;
        }

        .cs__orb--1 {
            width: 320px;
            height: 320px;
            top: 10%;
            left: -5%;
            background: var(--gold-soft);
        }

        .cs__orb--2 {
            width: 280px;
            height: 280px;
            bottom: 5%;
            right: -8%;
            background: rgba(255, 255, 255, 0.06);
            animation-delay: -4s;
        }

        @keyframes csFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(24px, -18px); }
        }

        /* Content */
        .cs__content {
            position: relative;
            z-index: 3;
            width: min(100%, 42rem);
            text-align: center;
            transform: translate(var(--parallax-x, 0), var(--parallax-y, 0));
            transition: transform 0.15s ease-out;
        }

        .cs__logo-wrap {
            margin-bottom: clamp(2rem, 5vw, 3rem);
            opacity: 0;
            animation: csFadeUp 1s cubic-bezier(0.22, 1, 0.36, 1) 0.2s forwards;
        }

        .cs__logo {
            display: block;
            margin: 0 auto;
            width: min(240px, 70vw);
            height: auto;
            filter: drop-shadow(0 8px 32px rgba(0, 0, 0, 0.45));
        }

        .cs__logo-fallback {
            font-size: clamp(1.25rem, 3vw, 1.5rem);
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin: 0;
        }

        .cs__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0 0 1.25rem;
            font-size: 0.6875rem;
            font-weight: 500;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0;
            animation: csFadeUp 1s cubic-bezier(0.22, 1, 0.36, 1) 0.45s forwards;
        }

        .cs__eyebrow::before,
        .cs__eyebrow::after {
            content: "";
            width: 2.5rem;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .cs__title {
            margin: 0 0 1rem;
            font-family: var(--font-heading);
            font-size: clamp(3rem, 10vw, 5.5rem);
            font-weight: 400;
            line-height: 0.95;
            letter-spacing: -0.02em;
            text-transform: uppercase;
            opacity: 0;
            animation: csFadeUp 1.1s cubic-bezier(0.22, 1, 0.36, 1) 0.55s forwards;
        }

        .cs__title em {
            font-style: italic;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.92);
        }

        .cs__tagline {
            margin: 0 0 2.5rem;
            font-size: clamp(1rem, 2.2vw, 1.125rem);
            font-weight: 300;
            letter-spacing: 0.04em;
            color: var(--muted);
            opacity: 0;
            animation: csFadeUp 1s cubic-bezier(0.22, 1, 0.36, 1) 0.7s forwards;
        }

        @keyframes csFadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Progress bar */
        .cs__progress {
            width: min(100%, 20rem);
            margin: 0 auto 2.5rem;
            opacity: 0;
            animation: csFadeUp 1s cubic-bezier(0.22, 1, 0.36, 1) 0.85s forwards;
        }

        .cs__progress-track {
            height: 2px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            overflow: hidden;
            position: relative;
        }

        .cs__progress-fill {
            height: 100%;
            width: 38%;
            background: linear-gradient(90deg, transparent, var(--gold), #e8d5a3, var(--gold), transparent);
            background-size: 200% 100%;
            border-radius: inherit;
            animation: csShimmer 2.8s ease-in-out infinite;
        }

        @keyframes csShimmer {
            0% { background-position: 200% 0; width: 28%; }
            50% { background-position: 0% 0; width: 72%; }
            100% { background-position: -200% 0; width: 38%; }
        }

        .cs__progress-label {
            display: block;
            margin-top: 0.75rem;
            font-size: 0.6875rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
        }

        /* CTA */
        .cs__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            opacity: 0;
            animation: csFadeUp 1s cubic-bezier(0.22, 1, 0.36, 1) 1s forwards;
        }

        .cs__btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.95rem 1.75rem;
            font-family: var(--font-body);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--black);
            background: var(--white);
            border: none;
            border-radius: 999px;
            cursor: pointer;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
        }

        .cs__btn::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(201, 169, 98, 0.35) 50%, transparent 70%);
            transform: translateX(-120%);
            transition: transform 0.6s ease;
        }

        .cs__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(201, 169, 98, 0.25);
            text-decoration: none;
        }

        .cs__btn:hover::before {
            transform: translateX(120%);
        }

        .cs__btn--ghost {
            color: var(--white);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: none;
        }

        .cs__btn--ghost:hover {
            border-color: var(--gold);
            color: var(--gold);
            box-shadow: 0 0 24px rgba(201, 169, 98, 0.15);
        }

        .cs__btn svg {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        }

        /* Footer strip */
        .cs__footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 3;
            padding: 1.25rem clamp(1.5rem, 4vw, 3rem);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            font-size: 0.6875rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            opacity: 0;
            animation: csFadeUp 1s ease 1.2s forwards;
        }

        .cs__footer a {
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: color 0.25s ease;
        }

        .cs__footer a:hover {
            color: var(--gold);
        }

        .cs__dots {
            display: flex;
            gap: 0.4rem;
            align-items: center;
        }

        .cs__dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: background 0.4s ease, transform 0.4s ease;
        }

        .cs__dot.is-active {
            background: var(--gold);
            transform: scale(1.35);
        }

        @media (max-width: 480px) {
            .cs__footer {
                flex-direction: column;
                text-align: center;
            }

            .cs__actions {
                flex-direction: column;
                width: 100%;
            }

            .cs__btn {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .cs__slide { animation: none; opacity: 0; }
            .cs__slide:first-child { opacity: 1; transform: none; }
            .cs__orb { animation: none; }
            .cs__progress-fill { animation: none; width: 55%; }
            .cs__content { transform: none !important; }
            .cs__logo-wrap,
            .cs__eyebrow,
            .cs__title,
            .cs__tagline,
            .cs__progress,
            .cs__actions,
            .cs__footer {
                opacity: 1;
                animation: none;
            }
        }
    </style>
</head>
<body>
    <div class="cs" id="coming-soon">
        <div class="cs__bg" aria-hidden="true">
            <div class="cs__slide"></div>
            <div class="cs__slide"></div>
            <div class="cs__slide"></div>
        </div>
        <div class="cs__overlay" aria-hidden="true"></div>
        <div class="cs__grain" aria-hidden="true"></div>
        <div class="cs__orb cs__orb--1" aria-hidden="true"></div>
        <div class="cs__orb cs__orb--2" aria-hidden="true"></div>

        <main class="cs__content" id="cs-content">
            <div class="cs__logo-wrap">
                @if (file_exists(public_path('assets/images/ksb_logo.svg')))
                    <img src="{{ asset('assets/images/ksb_logo.svg') }}" alt="KSB Luxury Homes" class="cs__logo" width="240" height="80">
                @else
                    <p class="cs__logo-fallback">KSB Luxury Homes</p>
                @endif
            </div>

            <p class="cs__eyebrow">Sydney North Shore</p>

            <h1 class="cs__title">Coming <em>Soon</em></h1>

            <p class="cs__tagline">Big launch coming soon</p>

            <div class="cs__progress" role="status" aria-label="Launch in progress">
                <div class="cs__progress-track">
                    <div class="cs__progress-fill"></div>
                </div>
                <span class="cs__progress-label">Preparing something exceptional</span>
            </div>

            <div class="cs__actions">
                <a href="https://www.instagram.com/ksbhomes/" class="cs__btn" target="_blank" rel="noopener noreferrer">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    Follow on Instagram
                </a>
                <a href="mailto:info@ksbhomes.com.au" class="cs__btn cs__btn--ghost">Get in touch</a>
            </div>
        </main>

        <footer class="cs__footer">
            <span>&copy; {{ date('Y') }} KSB Luxury Homes</span>
            <div class="cs__dots" id="cs-dots" aria-hidden="true">
                <span class="cs__dot is-active"></span>
                <span class="cs__dot"></span>
                <span class="cs__dot"></span>
            </div>
            <a href="https://www.instagram.com/ksbhomes/" target="_blank" rel="noopener noreferrer">@ksbhomes</a>
        </footer>
    </div>

    <script>
        (function () {
            const content = document.getElementById('cs-content');
            const dots = document.querySelectorAll('#cs-dots .cs__dot');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (content && !reducedMotion) {
                document.addEventListener('mousemove', function (e) {
                    const x = (e.clientX / window.innerWidth - 0.5) * 16;
                    const y = (e.clientY / window.innerHeight - 0.5) * 12;
                    content.style.setProperty('--parallax-x', x + 'px');
                    content.style.setProperty('--parallax-y', y + 'px');
                });
            }

            if (dots.length) {
                let active = 0;
                setInterval(function () {
                    dots[active].classList.remove('is-active');
                    active = (active + 1) % dots.length;
                    dots[active].classList.add('is-active');
                }, 6000);
            }
        })();
    </script>
</body>
</html>
