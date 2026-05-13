@extends('admin.layout')

@section('title', 'Contact lead #'.$enquiry->id)

@section('content')
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
            <h2 style="margin:0;">Contact lead #{{ $enquiry->id }}</h2>
            <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-btn admin-btn--secondary">Back to list</a>
        </div>
        <p class="admin-muted" style="margin-top:0;">Received {{ $enquiry->created_at?->format('l, j F Y \a\t g:i a') }}.</p>

        @if ($enquiry->hasAttachment())
            <p style="margin-bottom: 1.25rem;">
                <strong>Plans / drawings:</strong>
                <a href="{{ route('admin.contact-enquiries.attachment', $enquiry) }}" class="admin-btn" style="margin-left: 0.5rem;">
                    Download {{ $enquiry->attachment_original_name ?: 'attachment' }}
                </a>
            </p>
        @else
            <p class="admin-muted" style="margin-bottom: 1.25rem;"><strong>Plans / drawings:</strong> none uploaded, or file no longer on server.</p>
        @endif

        <table class="admin-table">
            <tbody>
                <tr><th style="width: 220px;">Full name</th><td>{{ $enquiry->full_name }}</td></tr>
                <tr><th>Phone</th><td>{{ $enquiry->phone }}</td></tr>
                <tr><th>Email</th><td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td></tr>
                <tr><th>Suburb / postcode</th><td>{{ $enquiry->suburb_postcode }}</td></tr>
                <tr><th>Looking to do</th><td>{{ implode(', ', $enquiry->looking_to_do ?? []) }}</td></tr>
                <tr><th>Own land?</th><td>{{ $enquiry->land_owner === 'yes' ? 'Yes' : 'No' }}</td></tr>
                <tr><th>Site address</th><td>{{ $enquiry->site_address ?: '—' }}</td></tr>
                <tr><th>Project type</th><td>{{ $enquiry->project_type }}</td></tr>
                <tr><th>Budget</th><td>{{ $enquiry->budget }}</td></tr>
                <tr><th>Timeline</th><td>{{ $enquiry->timeline }}</td></tr>
                <tr><th>Project stage</th><td>{{ $enquiry->project_stage }}</td></tr>
                <tr><th>Project goal</th><td>{{ $enquiry->project_goal }}</td></tr>
                <tr><th>Est. project value</th><td>{{ $enquiry->estimated_project_value ?: '—' }}</td></tr>
                <tr><th>No. of dwellings</th><td>{{ $enquiry->number_of_dwellings ?: '—' }}</td></tr>
                <tr><th>Looking for (JV/dev)</th><td>{{ $enquiry->looking_for_partner ?: '—' }}</td></tr>
                <tr><th>How they heard about us</th><td>{{ $enquiry->hear_about_us }}{{ $enquiry->hear_about_us === 'Other' && $enquiry->hear_about_other ? ' – '.$enquiry->hear_about_other : '' }}</td></tr>
                <tr><th>Message</th><td style="white-space: pre-wrap;">{{ $enquiry->message ?: '—' }}</td></tr>
                <tr><th>Consent</th><td>{{ $enquiry->consent ? 'Yes' : 'No' }}</td></tr>
                @if ($enquiry->attachment_storage_path)
                    <tr><th>Stored file path</th><td><code style="font-size:0.8rem;">{{ $enquiry->attachment_storage_path }}</code></td></tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
