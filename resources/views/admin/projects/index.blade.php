@extends('admin.layout')

@section('title', 'Projects')

@section('content')
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="margin:0;">Projects</h2>
            <a href="{{ route('admin.projects.create') }}" class="admin-btn">Add Project</a>
        </div>
        @if ($projects->isEmpty())
            <p>No projects yet. <a href="{{ route('admin.projects.create') }}">Add one</a>.</p>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Exclusive</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->category->name ?? '-' }}</td>
                            <td>{{ $project->is_exclusive_access ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">Edit</a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="post" style="display:inline;" onsubmit="return confirm('Delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger" style="padding: 0.25rem 0.5rem; font-size: 0.8125rem;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
