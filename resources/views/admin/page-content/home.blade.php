@extends('admin.layout')

@section('title', 'Page Content – Home')

@section('content')
    <div class="admin-card admin-card--page-editor">
        @include('admin.page-content._tabs', ['activeTab' => 'home'])
        <p class="admin-muted" style="margin-top:-0.5rem; margin-bottom:1.25rem;">Edit homepage SEO, hero text, about section, and right-side image.</p>

        <form action="{{ route('admin.page-content.home.update') }}" method="post" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')

            <h3 class="admin-section-title">SEO</h3>
            <div class="form-group">
                <label for="seo_title">Browser title *</label>
                <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $content['seo_title']) }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="seo_description">Meta description *</label>
                <textarea name="seo_description" id="seo_description" required maxlength="500">{{ old('seo_description', $content['seo_description']) }}</textarea>
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.5rem 0;">

            <h3 class="admin-section-title">Home hero</h3>
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

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.5rem 0;">

            <h3 class="admin-section-title">About section</h3>
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
                    <p class="admin-muted" style="margin-top: 0.5rem; margin-bottom: 0.25rem;">Current image</p>
                    <div class="admin-thumb-preview">
                        <img src="{{ asset('storage/'.$content['about_image']) }}" alt="Current about image preview">
                    </div>
                @endif
            </div>

            <button type="submit" class="admin-btn">Save Home Content</button>
        </form>
    </div>
@endsection
