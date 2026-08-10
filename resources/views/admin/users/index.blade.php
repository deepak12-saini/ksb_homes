@extends('admin.layout')

@section('title', 'Manage users')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Users</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Create marketing logins for content and photo updates, or additional admins.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="admin-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Add user
            </a>
        </div>

        @if ($users->isEmpty())
            <div class="admin-empty">
                <h3>No users yet</h3>
                <p>Add a marketing team login so they can update website content and photos.</p>
                <a href="{{ route('admin.users.create') }}" class="admin-btn">Add user</a>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email (login)</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="admin-table__actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="admin-table__strong">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="admin-badge {{ $user->isAdmin() ? 'admin-badge--brand' : 'admin-badge--info' }}">
                                        {{ $user->isAdmin() ? 'Admin' : 'Marketing' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at?->format('j M Y') }}</td>
                                <td class="admin-table__actions">
                                    <span class="admin-btn-group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="admin-btn admin-btn--secondary admin-btn--sm">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete user “{{ $user->email }}”?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">Delete</button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $users->links('admin.partials.pagination', ['itemLabel' => 'user']) }}
        @endif
    </div>
@endsection
