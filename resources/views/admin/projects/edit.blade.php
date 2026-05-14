@extends('admin.layout')

@section('title', 'Edit Project')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Edit Project</h2>
        <form action="{{ route('admin.projects.update', $project) }}" method="post" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $project->slug) }}">
            </div>
            <div class="form-group">
                <label for="project_category_id">Category *</label>
                <select name="project_category_id" id="project_category_id" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('project_category_id', $project->project_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                @if ($project->image)
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">Current: <img src="{{ $project->public_image_url }}" alt="" style="max-height: 60px; vertical-align: middle;"></p>
                @endif
            </div>
            <h3 style="margin: 1.5rem 0 0.75rem; font-size: 1rem;">Project details (public page)</h3>
            <div class="form-group">
                <label for="architecture">Architecture</label>
                <input type="text" name="architecture" id="architecture" value="{{ old('architecture', $project->architecture) }}" placeholder="e.g. by KSB homes">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" name="status" id="status" value="{{ old('status', $project->status) }}" placeholder="e.g. Current">
            </div>
            <div class="form-group">
                <label for="property_type">Property type</label>
                <input type="text" name="property_type" id="property_type" value="{{ old('property_type', $project->property_type) }}">
            </div>
            <div class="form-group">
                <label for="no">No.</label>
                <input type="text" name="no" id="no" value="{{ old('no', $project->no) }}">
            </div>
            <div class="form-group">
                <label for="levels">Levels</label>
                <input type="text" name="levels" id="levels" value="{{ old('levels', $project->levels) }}">
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="featured_on_home" value="1" {{ old('featured_on_home', $project->featured_on_home) ? 'checked' : '' }}> Show on home page (featured in Projects section)</label>
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_exclusive_access" value="1" {{ old('is_exclusive_access', $project->is_exclusive_access) ? 'checked' : '' }}> Show “KSB SELECT – CUSTOM PROJECTS” badge on card</label>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project->sort_order) }}">
            </div>
            <button type="submit" class="admin-btn">Update Project</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary" style="margin-left: 0.5rem;">Cancel</a>
        </form>
    </div>
@endsection
