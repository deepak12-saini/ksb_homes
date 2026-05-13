@extends('admin.layout')

@section('title', 'Page Content')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Page Content</h2>
        @include('admin.page-content._tabs', ['activeTab' => 'home'])

        <form action="{{ route('admin.page-content.home.update') }}" method="post" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')

            <h3 style="margin-top:0;">Home Hero</h3>
            <div class="form-group">
                <label for="hero_title_line_1">Hero title line 1 *</label>
                <input type="text" name="hero_title_line_1" id="hero_title_line_1" value="{{ old('hero_title_line_1', $content['hero_title_line_1']) }}" required>
            </div>
            <div class="form-group">
                <label for="hero_title_line_2">Hero title line 2 *</label>
                <input type="text" name="hero_title_line_2" id="hero_title_line_2" value="{{ old('hero_title_line_2', $content['hero_title_line_2']) }}" required>
            </div>
            <div class="form-group">
                <label for="hero_tagline">Hero tagline *</label>
                <input type="text" name="hero_tagline" id="hero_tagline" value="{{ old('hero_tagline', $content['hero_tagline']) }}" required>
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">About Section</h3>
            <div class="form-group">
                <label for="about_paragraph_1">Paragraph 1 *</label>
                <textarea name="about_paragraph_1" id="about_paragraph_1" required>{{ old('about_paragraph_1', $content['about_paragraph_1']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="about_paragraph_2">Paragraph 2 *</label>
                <textarea name="about_paragraph_2" id="about_paragraph_2" required>{{ old('about_paragraph_2', $content['about_paragraph_2']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="about_paragraph_3">Paragraph 3 *</label>
                <textarea name="about_paragraph_3" id="about_paragraph_3" required>{{ old('about_paragraph_3', $content['about_paragraph_3']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="about_paragraph_4">Paragraph 4 *</label>
                <textarea name="about_paragraph_4" id="about_paragraph_4" required>{{ old('about_paragraph_4', $content['about_paragraph_4']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="about_image">Right-side image</label>
                <input type="file" name="about_image" id="about_image" accept="image/*">
                @if (!empty($content['about_image']))
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">
                        Current: <img src="{{ asset('storage/'.$content['about_image']) }}" alt="" style="max-height: 60px; vertical-align: middle;">
                    </p>
                @endif
            </div>

            <button type="submit" class="admin-btn">Save Home Content</button>
        </form>
    </div>
@endsection
