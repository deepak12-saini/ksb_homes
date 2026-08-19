@extends('admin.layout')

@section('title', 'Instagram Posts')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Instagram posts</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Add Instagram embed codes or post URLs to show on the home page.</p>
            </div>
            <a href="{{ route('admin.instagram-posts.create') }}" class="admin-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Add Post
            </a>
        </div>

        <form method="get" action="{{ route('admin.instagram-posts.index') }}" class="admin-toolbar">
            <label class="admin-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search note or Instagram URL" aria-label="Search Instagram posts">
            </label>
            <button type="submit" class="admin-btn admin-btn--secondary">Filter</button>
            @if ($search !== '')
                <a href="{{ route('admin.instagram-posts.index') }}" class="admin-btn admin-btn--secondary">Clear</a>
            @endif
        </form>

        @if ($posts->isEmpty())
            <div class="admin-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="3.2"/><path d="M16.5 7.5h.01"/></svg>
                <h3>{{ $search !== '' ? 'No Instagram posts match your search' : 'No Instagram posts yet' }}</h3>
                <p>{{ $search !== '' ? 'Try a different keyword or clear the filter.' : 'Add embed codes or post URLs here to show them on the home page.' }}</p>
                <a href="{{ route('admin.instagram-posts.create') }}" class="admin-btn">Add Post</a>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Post</th>
                            <th>Admin note</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th class="admin-table__actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <img src="{{ $post->displayImageUrl() }}" alt="Instagram post preview" style="width: 56px; height: 56px; object-fit: cover; border-radius: 8px; display: block;">
                                </td>
                                <td class="admin-table__strong">
                                    <a href="{{ $post->instagram_url }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($post->instagram_url, 60) }}</a>
                                </td>
                                <td>{{ $post->admin_note ?: '—' }}</td>
                                <td>
                                    <span class="admin-badge {{ $post->is_active ? 'admin-badge--on' : 'admin-badge--off' }}">
                                        {{ $post->is_active ? 'Active' : 'Hidden' }}
                                    </span>
                                </td>
                                <td class="admin-table__id">{{ $post->sort_order }}</td>
                                <td class="admin-table__actions">
                                    <span class="admin-btn-group">
                                        <a href="{{ $post->instagram_url }}" target="_blank" rel="noopener" class="admin-btn admin-btn--secondary admin-btn--sm">Open</a>
                                        <a href="{{ route('admin.instagram-posts.edit', $post) }}" class="admin-btn admin-btn--secondary admin-btn--sm">Edit</a>
                                        <form action="{{ route('admin.instagram-posts.destroy', $post) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this Instagram post? This cannot be undone.');">
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

            {{ $posts->links('admin.partials.pagination', ['itemLabel' => 'post']) }}
        @endif
    </div>
@endsection
