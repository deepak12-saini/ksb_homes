@extends('admin.layout')

@section('title', 'Page Content – Our Story')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Page Content</h2>
        @include('admin.page-content._tabs', ['activeTab' => 'our-story'])

        <form action="{{ route('admin.page-content.our-story.update') }}" method="post" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')

            <h3 style="margin-top:0;">SEO</h3>
            <div class="form-group">
                <label for="seo_title">Browser title *</label>
                <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $content['seo_title']) }}" required>
            </div>
            <div class="form-group">
                <label for="seo_description">Meta description *</label>
                <textarea name="seo_description" id="seo_description" required>{{ old('seo_description', $content['seo_description']) }}</textarea>
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Hero</h3>
            <div class="form-group">
                <label for="hero_label">Label above title *</label>
                <input type="text" name="hero_label" id="hero_label" value="{{ old('hero_label', $content['hero_label']) }}" required>
            </div>
            <div class="form-group">
                <label for="hero_title">Main heading *</label>
                <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $content['hero_title']) }}" required>
            </div>
            <div class="form-group">
                <label for="hero_image">Hero background image</label>
                <input type="file" name="hero_image" id="hero_image" accept="image/*">
                @if (!empty($content['hero_image']))
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">
                        Current: <img src="{{ asset('storage/'.$content['hero_image']) }}" alt="" style="max-height: 60px; vertical-align: middle;">
                    </p>
                @endif
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Vision block</h3>
            <div class="form-group">
                <label for="vision_heading">Section heading *</label>
                <input type="text" name="vision_heading" id="vision_heading" value="{{ old('vision_heading', $content['vision_heading']) }}" required>
            </div>
            <div class="form-group">
                <label for="vision_paragraph_1">Paragraph 1 *</label>
                <textarea name="vision_paragraph_1" id="vision_paragraph_1" required>{{ old('vision_paragraph_1', $content['vision_paragraph_1']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="vision_paragraph_2">Paragraph 2 *</label>
                <textarea name="vision_paragraph_2" id="vision_paragraph_2" required>{{ old('vision_paragraph_2', $content['vision_paragraph_2']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="vision_image">Vision image (right side)</label>
                <input type="file" name="vision_image" id="vision_image" accept="image/*">
                @if (!empty($content['vision_image']))
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">
                        Current: <img src="{{ asset('storage/'.$content['vision_image']) }}" alt="" style="max-height: 60px; vertical-align: middle;">
                    </p>
                @endif
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Founders block</h3>
            <div class="form-group">
                <label for="founders_heading">Section heading *</label>
                <input type="text" name="founders_heading" id="founders_heading" value="{{ old('founders_heading', $content['founders_heading']) }}" required>
            </div>
            <div class="form-group">
                <label for="founders_paragraph_1">Paragraph *</label>
                <textarea name="founders_paragraph_1" id="founders_paragraph_1" required>{{ old('founders_paragraph_1', $content['founders_paragraph_1']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="founders_image">Founders image</label>
                <input type="file" name="founders_image" id="founders_image" accept="image/*">
                @if (!empty($content['founders_image']))
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">
                        Current: <img src="{{ asset('storage/'.$content['founders_image']) }}" alt="" style="max-height: 60px; vertical-align: middle;">
                    </p>
                @endif
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Services</h3>
            <div class="form-group">
                <label for="services_heading">Section heading *</label>
                <input type="text" name="services_heading" id="services_heading" value="{{ old('services_heading', $content['services_heading']) }}" required>
            </div>
            <div class="form-group">
                <label for="services_intro">Intro paragraph *</label>
                <textarea name="services_intro" id="services_intro" required>{{ old('services_intro', $content['services_intro']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="services_architecture_label">Row 1 – label *</label>
                <input type="text" name="services_architecture_label" id="services_architecture_label" value="{{ old('services_architecture_label', $content['services_architecture_label']) }}" required>
            </div>
            <div class="form-group">
                <label for="services_architecture_text">Row 1 – text *</label>
                <textarea name="services_architecture_text" id="services_architecture_text" required>{{ old('services_architecture_text', $content['services_architecture_text']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="services_development_label">Row 2 – label *</label>
                <input type="text" name="services_development_label" id="services_development_label" value="{{ old('services_development_label', $content['services_development_label']) }}" required>
            </div>
            <div class="form-group">
                <label for="services_development_text">Row 2 – text *</label>
                <textarea name="services_development_text" id="services_development_text" required>{{ old('services_development_text', $content['services_development_text']) }}</textarea>
            </div>
            <div class="form-group">
                <label for="services_construction_label">Row 3 – label *</label>
                <input type="text" name="services_construction_label" id="services_construction_label" value="{{ old('services_construction_label', $content['services_construction_label']) }}" required>
            </div>
            <div class="form-group">
                <label for="services_construction_text">Row 3 – text *</label>
                <textarea name="services_construction_text" id="services_construction_text" required>{{ old('services_construction_text', $content['services_construction_text']) }}</textarea>
            </div>

            <button type="submit" class="admin-btn">Save Our Story</button>
        </form>
    </div>
@endsection
