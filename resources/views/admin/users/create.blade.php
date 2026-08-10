@extends('admin.layout')

@section('title', 'Add user')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Add user</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Marketing users can edit projects and page content only.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">Back</a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="post" class="admin-form">
            @csrf
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="email">Email (login username) *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255">
                <p class="admin-muted" style="margin:0.35rem 0 0;">They sign in at /admin/login with this email.</p>
            </div>
            <div class="form-group">
                <label for="role">Role *</label>
                <select name="role" id="role" required>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role', 'marketing') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" name="password" id="password" required minlength="8" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" autocomplete="new-password">
            </div>
            <button type="submit" class="admin-btn">Create user</button>
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary" style="margin-left:0.5rem;">Cancel</a>
        </form>
    </div>
@endsection
