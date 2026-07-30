@extends('admin.layout')

@section('title', 'Projects')

@section('content')
    <div class="admin-card">
        <div class="admin-card__head">
            <div>
                <h2>Projects</h2>
                <p class="admin-muted" style="margin: 0.2rem 0 0;">Manage the portfolio shown on the website.</p>
            </div>
            <a href="{{ route('admin.projects.create') }}" class="admin-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Add Project
            </a>
        </div>

        <form method="get" action="{{ route('admin.projects.index') }}" class="admin-toolbar">
            <label class="admin-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search by name, slug or location" aria-label="Search projects">
            </label>
            <select name="category" aria-label="Filter by category">
                <option value="">All categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId === $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn admin-btn--secondary">Filter</button>
            @if ($search !== '' || $categoryId)
                <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary">Clear</a>
            @endif
        </form>

        @if ($projects->isEmpty())
            <div class="admin-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-5h6v5"/></svg>
                <h3>{{ $search !== '' || $categoryId ? 'No projects match your filters' : 'No projects yet' }}</h3>
                <p>{{ $search !== '' || $categoryId ? 'Try a different search term or category.' : 'Add your first project to show it on the website.' }}</p>
                @if ($search !== '' || $categoryId)
                    <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary">Clear filters</a>
                @else
                    <a href="{{ route('admin.projects.create') }}" class="admin-btn">Add Project</a>
                @endif
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Home page</th>
                            <th>Exclusive</th>
                            <th>Order</th>
                            <th class="admin-table__actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="admin-table__strong">{{ $project->name }}</td>
                                <td>{{ $project->category->name ?? '—' }}</td>
                                <td>{{ $project->location ?: '—' }}</td>
                                <td>
                                    <span class="admin-badge {{ $project->featured_on_home ? 'admin-badge--on' : 'admin-badge--off' }}">
                                        {{ $project->featured_on_home ? 'Visible' : 'Hidden' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="admin-badge {{ $project->is_exclusive_access ? 'admin-badge--brand' : 'admin-badge--off' }}">
                                        {{ $project->is_exclusive_access ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="admin-table__id">{{ $project->sort_order }}</td>
                                <td class="admin-table__actions">
                                    <span class="admin-btn-group">
                                        <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener" class="admin-btn admin-btn--secondary admin-btn--sm">View</a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--secondary admin-btn--sm">Edit</a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete “{{ $project->name }}”? This cannot be undone.');">
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

            {{ $projects->links('admin.partials.pagination', ['itemLabel' => 'project']) }}
        @endif
    </div>
@endsection
