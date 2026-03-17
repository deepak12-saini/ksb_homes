<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login – KSB homes</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .login-card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); width: 100%; max-width: 360px; }
        .login-card h1 { margin: 0 0 1.5rem; font-size: 1.25rem; }
        .login-card label { display: block; margin-bottom: 0.25rem; font-weight: 500; }
        .login-card input { width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 1rem; box-sizing: border-box; }
        .login-card button { width: 100%; padding: 0.75rem; background: #1a1a1a; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        .login-card .error { color: #dc2626; font-size: 0.875rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Admin Login</h1>
        @if ($errors->has('username'))
            <p class="error">{{ $errors->first('username') }}</p>
        @endif
        <form method="post" action="{{ route('admin.login.submit') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
