<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login – KSB Luxury Homes</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
            color: #0f172a;
            background: #0b1120;
            background-image:
                radial-gradient(60rem 40rem at 15% -10%, rgba(201, 169, 98, 0.22), transparent 60%),
                radial-gradient(45rem 35rem at 100% 110%, rgba(56, 89, 145, 0.28), transparent 60%);
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2.25rem 2rem 2rem;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 18px;
            box-shadow: 0 30px 70px -25px rgba(0, 0, 0, 0.6);
        }

        .login-logo {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            margin-bottom: 1.1rem;
            border-radius: 13px;
            background: linear-gradient(140deg, #c9a962, #a98c48);
            color: #12161f;
            font-weight: 700;
            font-size: 0.92rem;
        }

        .login-card h1 {
            margin: 0 0 0.3rem;
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .login-card .sub {
            margin: 0 0 1.75rem;
            font-size: 0.88rem;
            color: #64748b;
        }

        .login-card label {
            display: block;
            margin-bottom: 0.35rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #475569;
        }

        .login-card input {
            width: 100%;
            padding: 0.68rem 0.85rem;
            margin-bottom: 1.1rem;
            font-family: inherit;
            font-size: 0.92rem;
            color: #0f172a;
            background: #fff;
            border: 1px solid #e5e8ee;
            border-radius: 10px;
            transition: border-color 0.16s ease, box-shadow 0.16s ease;
        }

        .login-card input:focus {
            outline: none;
            border-color: #c9a962;
            box-shadow: 0 0 0 3px rgba(201, 169, 98, 0.18);
        }

        .login-card button {
            width: 100%;
            padding: 0.78rem;
            margin-top: 0.35rem;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            background: #0f172a;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.16s ease, transform 0.14s ease;
        }

        .login-card button:hover { background: #1e293b; transform: translateY(-1px); }
        .login-card button:active { transform: translateY(0); }

        .login-card .error {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 0.85rem;
            margin-bottom: 1.25rem;
            font-size: 0.86rem;
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
        }

        .login-card .error svg { width: 17px; height: 17px; flex: none; }

        .login-back {
            display: block;
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.83rem;
            color: #64748b;
            text-decoration: none;
        }

        .login-back:hover { color: #0f172a; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">KSB</div>
        <h1>Welcome back</h1>
        <p class="sub">Sign in to manage the KSB Luxury Homes website.</p>

        @if ($errors->has('username'))
            <p class="error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7.5v5M12 16h.01"/></svg>
                <span>{{ $errors->first('username') }}</span>
            </p>
        @endif

        <form method="post" action="{{ route('admin.login.submit') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" autocomplete="username" required autofocus>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" autocomplete="current-password" required>

            <button type="submit">Sign in</button>
        </form>

        <a href="{{ url('/') }}" class="login-back">← Back to website</a>
    </div>
</body>
</html>
