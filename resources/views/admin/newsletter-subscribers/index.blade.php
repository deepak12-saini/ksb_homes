@extends('admin.layout')

@section('title', 'Newsletter subscribers')

@section('content')
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
            <h2 style="margin:0;">Newsletter subscribers</h2>
            <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn--secondary">Dashboard</a>
        </div>
        <p class="admin-muted" style="margin-top:0;">Emails collected from the site newsletter signup form.</p>

        @if ($subscribers->isEmpty())
            <p>No subscribers yet.</p>
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
                                <td>{{ $row->id }}</td>
                                <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                <td>{{ $row->created_at?->format('M j, Y g:i a') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1rem;">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>
@endsection
