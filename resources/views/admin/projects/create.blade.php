@extends('admin.layout')

@section('title', 'Add Project')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Add Project</h2>
        <form action="{{ route('admin.projects.store') }}" method="post" enctype="multipart/form-data" class="admin-form">
            @csrf
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug (leave blank to auto-generate)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. the-gallery">
            </div>
            <div class="form-group">
                <label for="project_category_id">Category *</label>
                <select name="project_category_id" id="project_category_id" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('project_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="featured_on_home" value="1" {{ old('featured_on_home') ? 'checked' : '' }}> Show on home page (featured in Projects section)</label>
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_exclusive_access" value="1" {{ old('is_exclusive_access') ? 'checked' : '' }}> Show “KSB SELECT – CUSTOM PROJECTS” badge on card</label>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}">
            </div>
            <button type="submit" class="admin-btn">Create Project</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary" style="margin-left: 0.5rem;">Cancel</a>
        </form>
    </div>
@endsection
