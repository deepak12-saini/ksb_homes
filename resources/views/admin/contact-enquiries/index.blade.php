@extends('admin.layout')

@section('title', 'Contact leads')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Contact form leads</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Submissions from the contact / enquire form. Plans are downloadable from each lead’s detail page.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn--secondary">Dashboard</a>
        </div>

        <form method="get" action="{{ route('admin.contact-enquiries.index') }}" class="admin-toolbar">
            <label class="admin-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search name, email, phone or suburb" aria-label="Search leads">
            </label>
            <select name="per_page" aria-label="Rows per page">
                @foreach ([15, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ $perPage === $size ? 'selected' : '' }}>{{ $size }} per page</option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn admin-btn--secondary">Apply</button>
            @if ($search !== '')
                <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-btn admin-btn--secondary">Clear</a>
            @endif
        </form>

        @if ($enquiries->isEmpty())
            <div class="admin-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="m4 7 8 6 8-6"/></svg>
                <h3>{{ $search !== '' ? 'No leads match your search' : 'No contact leads yet' }}</h3>
                <p>{{ $search !== '' ? 'Try a different name, email or suburb.' : 'New enquiries from the website will appear here.' }}</p>
                @if ($search !== '')
                    <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-btn admin-btn--secondary">Clear search</a>
                @endif
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Received</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Suburb</th>
                            <th>Project type</th>
                            <th>Plans</th>
                            <th class="admin-table__actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $row)
                            <tr>
                                <td class="admin-table__id">{{ $row->id }}</td>
                                <td>{{ $row->created_at?->format('j M Y, g:i a') }}</td>
                                <td class="admin-table__strong">{{ $row->full_name }}</td>
                                <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                <td>{{ $row->suburb_postcode }}</td>
                                <td>{{ $row->project_type }}</td>
                                <td>
                                    <span class="admin-badge {{ $row->hasAttachment() ? 'admin-badge--info' : 'admin-badge--off' }}">
                                        {{ $row->hasAttachment() ? 'Attached' : 'None' }}
                                    </span>
                                </td>
                                <td class="admin-table__actions">
                                    <a href="{{ route('admin.contact-enquiries.show', $row) }}" class="admin-btn admin-btn--secondary admin-btn--sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $enquiries->links('admin.partials.pagination', ['itemLabel' => 'lead']) }}
        @endif
    </div>
@endsection
