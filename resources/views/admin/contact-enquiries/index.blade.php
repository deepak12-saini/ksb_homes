@extends('admin.layout')

@section('title', 'Contact leads')

@section('content')
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
            <h2 style="margin:0;">Contact form leads</h2>
            <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn--secondary">Dashboard</a>
        </div>
        <p class="admin-muted" style="margin-top:0;">All submissions from the main contact / enquire form. Plans are stored on disk; download from each lead’s detail page.</p>

        @if ($enquiries->isEmpty())
            <p>No contact leads yet.</p>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Suburb</th>
                            <th>Project type</th>
                            <th>Plans</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->created_at?->format('Y-m-d H:i') }}</td>
                                <td>{{ $row->full_name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->suburb_postcode }}</td>
                                <td>{{ $row->project_type }}</td>
                                <td>{{ $row->hasAttachment() ? 'Yes' : '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.contact-enquiries.show', $row) }}" class="admin-btn admin-btn--secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1rem;">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>
@endsection
