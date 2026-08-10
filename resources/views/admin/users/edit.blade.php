@extends('admin.layout')

@section('title', 'Edit user')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Edit user</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Leave password blank to keep the current password.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">Back</a>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="post" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="email">Email (login username) *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="role">Role *</label>
                <select name="role" id="role" required>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" name="password" id="password" minlength="8" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" minlength="8" autocomplete="new-password">
            </div>
            <button type="submit" class="admin-btn">Update user</button>
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary" style="margin-left:0.5rem;">Cancel</a>
        </form>
    </div>
@endsection
