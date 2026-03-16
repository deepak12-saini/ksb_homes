<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') – KSB homes</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .admin-body { background: #f1f5f9; font-family: system-ui, sans-serif; padding: 1.5rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0; }
        .admin-header h1 { font-size: 1.25rem; margin: 0; }
        .admin-card { background: #fff; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        .admin-btn { display: inline-block; padding: 0.5rem 1rem; background: #1a1a1a; color: #fff; border-radius: 6px; text-decoration: none; font-size: 0.875rem; border: none; cursor: pointer; }
        .admin-btn:hover { background: #333; color: #fff; }
        .admin-btn--secondary { background: #e2e8f0; color: #1a1a1a; }
        .admin-btn--danger { background: #dc2626; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th, .admin-table td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .admin-table th { font-weight: 600; }
        .admin-form label { display: block; margin-bottom: 0.25rem; font-weight: 500; }
        .admin-form input[type="text"], .admin-form input[type="number"], .admin-form select { width: 100%; max-width: 400px; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 1rem; }
        .admin-form input[type="checkbox"] { margin-right: 0.5rem; }
        .admin-form .form-group { margin-bottom: 1rem; }
        .admin-alert { padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .admin-alert--success { background: #dcfce7; color: #166534; }
        .admin-alert--error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>KSB homes Admin</h1>
        <div>
            <a href="{{ url('/') }}" class="admin-btn admin-btn--secondary">View site</a>
            <form action="{{ route('admin.logout') }}" method="post" style="display:inline; margin-left: 0.5rem;">
                @csrf
                <button type="submit" class="admin-btn admin-btn--secondary">Logout</button>
            </form>
        </div>
    </header>
    @if (session('success'))
        <div class="admin-alert admin-alert--success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="admin-alert admin-alert--error">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</body>
</html>
