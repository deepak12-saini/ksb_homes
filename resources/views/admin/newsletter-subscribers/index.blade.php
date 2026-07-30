@extends('admin.layout')

@section('title', 'Newsletter subscribers')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Newsletter subscribers</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Emails collected from the site newsletter signup form.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn--secondary">Dashboard</a>
        </div>

        <form method="get" action="{{ route('admin.newsletter-subscribers.index') }}" class="admin-toolbar">
            <label class="admin-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search by email" aria-label="Search subscribers">
            </label>
            <select name="per_page" aria-label="Rows per page">
                @foreach ([15, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ $perPage === $size ? 'selected' : '' }}>{{ $size }} per page</option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn admin-btn--secondary">Apply</button>
            @if ($search !== '')
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-btn admin-btn--secondary">Clear</a>
            @endif
        </form>

        @if ($subscribers->isEmpty())
            <div class="admin-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                <h3>{{ $search !== '' ? 'No subscribers match your search' : 'No subscribers yet' }}</h3>
                <p>{{ $search !== '' ? 'Try a different email address.' : 'Signups from the website newsletter form will appear here.' }}</p>
                @if ($search !== '')
                    <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-btn admin-btn--secondary">Clear search</a>
                @endif
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Subscribed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $row)
                            <tr>
                                <td class="admin-table__id">{{ $row->id }}</td>
                                <td class="admin-table__strong"><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                <td>{{ $row->created_at?->format('j M Y, g:i a') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $subscribers->links('admin.partials.pagination', ['itemLabel' => 'subscriber']) }}
        @endif
    </div>
@endsection
