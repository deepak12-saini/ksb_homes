@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Overview</h2>
        <p class="admin-muted">Use the sidebar to manage projects and page content. Stat cards open the related admin area.</p>

        <div class="admin-stat-grid">
            <a href="{{ route('admin.projects.index') }}" class="admin-stat admin-stat--link">
                <p class="admin-stat__value">{{ $projectsTotal }}</p>
                <p class="admin-stat__label">Projects in CMS</p>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="admin-stat admin-stat--link">
                <p class="admin-stat__value">{{ $projectsFeaturedHome }}</p>
                <p class="admin-stat__label">Featured on home</p>
            </a>
            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-stat admin-stat--link">
                <p class="admin-stat__value">{{ $newsletterTotal }}</p>
                <p class="admin-stat__label">Newsletter subscribers</p>
            </a>
            <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-stat admin-stat--link">
                <p class="admin-stat__value">{{ $contactEnquiriesTotal }}</p>
                <p class="admin-stat__label">Contact form leads</p>
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.5rem;">
            <h2 style="margin:0;">Recent contact form leads</h2>
            <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-btn admin-btn--secondary">View all</a>
        </div>
        <p class="admin-muted">Submissions from the main Contact / Enquire page (stored in the database).</p>

        @if ($recentContactEnquiries->isEmpty())
            <p class="admin-muted" style="margin-bottom:0;">No contact leads yet.</p>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Looking to do</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentContactEnquiries as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->created_at?->format('M j, Y g:i a') }}</td>
                                <td>{{ $lead->full_name }}</td>
                                <td><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
                                <td>{{ \Illuminate\Support\Str::limit(implode(', ', $lead->looking_to_do ?? []), 72) }}</td>
                                <td>
                                    <a href="{{ route('admin.contact-enquiries.show', $lead) }}" class="admin-btn admin-btn--secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">Open</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.5rem;">
            <h2 style="margin:0;">Recent newsletter sign-ups</h2>
            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-btn admin-btn--secondary">View all</a>
        </div>
        <p class="admin-muted">Latest emails from the site newsletter form.</p>

        @if ($recentNewsletterSubscribers->isEmpty())
            <p class="admin-muted" style="margin-bottom:0;">No subscribers yet.</p>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentNewsletterSubscribers as $sub)
                            <tr>
                                <td>{{ $sub->id }}</td>
                                <td>{{ $sub->created_at?->format('M j, Y g:i a') }}</td>
                                <td><a href="mailto:{{ $sub->email }}">{{ $sub->email }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
