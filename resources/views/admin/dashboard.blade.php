@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Overview</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">
                    @if ($isAdmin)
                        A snapshot of your site. Select a card to open that area.
                    @else
                        Update website content and project photos from the sidebar.
                    @endif
                </p>
            </div>
        </div>

        <div class="admin-stat-grid">
            <a href="{{ route('admin.projects.index') }}" class="admin-stat admin-stat--link">
                <span class="admin-stat__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-5h6v5"/></svg>
                </span>
                <p class="admin-stat__value">{{ $projectsTotal }}</p>
                <p class="admin-stat__label">Projects in CMS</p>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="admin-stat admin-stat--link">
                <span class="admin-stat__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 2.6 5.6 6.4.8-4.7 4.3 1.2 6.3L12 17l-5.5 3 1.2-6.3L3 9.4l6.4-.8z"/></svg>
                </span>
                <p class="admin-stat__value">{{ $projectsFeaturedHome }}</p>
                <p class="admin-stat__label">Featured on home</p>
            </a>
            <a href="{{ route('admin.page-content.home.edit') }}" class="admin-stat admin-stat--link">
                <span class="admin-stat__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M4 9h16"/><path d="M9 20V9"/></svg>
                </span>
                <p class="admin-stat__value">3</p>
                <p class="admin-stat__label">Editable pages</p>
            </a>
            <a href="{{ route('admin.instagram-posts.index') }}" class="admin-stat admin-stat--link">
                <span class="admin-stat__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="3.2"/><path d="M16.5 7.5h.01"/></svg>
                </span>
                <p class="admin-stat__value">{{ $instagramPostsTotal }}</p>
                <p class="admin-stat__label">Instagram posts</p>
            </a>
            @if ($isAdmin)
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-stat admin-stat--link">
                    <span class="admin-stat__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                    </span>
                    <p class="admin-stat__value">{{ $newsletterTotal }}</p>
                    <p class="admin-stat__label">Newsletter subscribers</p>
                </a>
                <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-stat admin-stat--link">
                    <span class="admin-stat__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="m4 7 8 6 8-6"/></svg>
                    </span>
                    <p class="admin-stat__value">{{ $contactEnquiriesTotal }}</p>
                    <p class="admin-stat__label">Contact form leads</p>
                </a>
            @endif
        </div>
    </div>

    @if ($isAdmin)
        <div class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h2>Recent contact form leads</h2>
                    <p class="admin-muted" style="margin: 0.2rem 0 0;">Latest submissions from the contact / enquire page.</p>
                </div>
                <a href="{{ route('admin.contact-enquiries.index') }}" class="admin-btn admin-btn--secondary">View all</a>
            </div>

            @if ($recentContactEnquiries->isEmpty())
                <div class="admin-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="m4 7 8 6 8-6"/></svg>
                    <h3>No contact leads yet</h3>
                    <p>New enquiries from the website will appear here.</p>
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
                                <th>Looking to do</th>
                                <th class="admin-table__actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentContactEnquiries as $lead)
                                <tr>
                                    <td class="admin-table__id">{{ $lead->id }}</td>
                                    <td>{{ $lead->created_at?->format('j M Y, g:i a') }}</td>
                                    <td class="admin-table__strong">{{ $lead->full_name }}</td>
                                    <td><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
                                    <td>{{ \Illuminate\Support\Str::limit(implode(', ', $lead->looking_to_do ?? []), 72) }}</td>
                                    <td class="admin-table__actions">
                                        <a href="{{ route('admin.contact-enquiries.show', $lead) }}" class="admin-btn admin-btn--secondary admin-btn--sm">Open</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h2>Recent newsletter sign-ups</h2>
                    <p class="admin-muted" style="margin: 0.2rem 0 0;">Latest emails from the site newsletter form.</p>
                </div>
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="admin-btn admin-btn--secondary">View all</a>
            </div>

            @if ($recentNewsletterSubscribers->isEmpty())
                <div class="admin-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/></svg>
                    <h3>No subscribers yet</h3>
                    <p>Signups from the newsletter form will appear here.</p>
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
                            @foreach ($recentNewsletterSubscribers as $sub)
                                <tr>
                                    <td class="admin-table__id">{{ $sub->id }}</td>
                                    <td class="admin-table__strong"><a href="mailto:{{ $sub->email }}">{{ $sub->email }}</a></td>
                                    <td>{{ $sub->created_at?->format('j M Y, g:i a') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @else
        <div class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h2>Quick links</h2>
                    <p class="admin-muted" style="margin: 0.2rem 0 0;">Common marketing tasks.</p>
                </div>
            </div>
            <div class="admin-btn-group" style="flex-wrap:wrap;">
                <a href="{{ route('admin.projects.index') }}" class="admin-btn">Manage projects</a>
                <a href="{{ route('admin.instagram-posts.index') }}" class="admin-btn admin-btn--secondary">Manage Instagram</a>
                <a href="{{ route('admin.page-content.home.edit') }}" class="admin-btn admin-btn--secondary">Edit Home</a>
                <a href="{{ route('admin.page-content.our-story.edit') }}" class="admin-btn admin-btn--secondary">Edit Our Story</a>
                <a href="{{ route('admin.page-content.contact.edit') }}" class="admin-btn admin-btn--secondary">Edit Contact</a>
            </div>
        </div>
    @endif
@endsection
