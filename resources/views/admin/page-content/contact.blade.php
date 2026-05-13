@extends('admin.layout')

@section('title', 'Page Content – Contact')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Page Content</h2>
        @include('admin.page-content._tabs', ['activeTab' => 'contact'])

        <form action="{{ route('admin.page-content.contact.update') }}" method="post" enctype="multipart/form-data" class="admin-form">
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
                <label for="hero_image">Hero image (optional; otherwise site uses assets/images/contact-hero.* or demo image)</label>
                <input type="file" name="hero_image" id="hero_image" accept="image/*">
                @if (!empty($content['hero_image']))
                    <p style="margin-top: 0.25rem; font-size: 0.875rem;">
                        Current: <img src="{{ asset('storage/'.$content['hero_image']) }}" alt="" style="max-height: 60px; vertical-align: middle;">
                    </p>
                @endif
            </div>
            <div class="form-group">
                <label for="hero_image_alt">Hero image alt text *</label>
                <input type="text" name="hero_image_alt" id="hero_image_alt" value="{{ old('hero_image_alt', $content['hero_image_alt']) }}" required>
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Contact details</h3>
            <div class="form-group">
                <label for="address_text">Address *</label>
                <input type="text" name="address_text" id="address_text" value="{{ old('address_text', $content['address_text']) }}" required>
            </div>
            <div class="form-group">
                <label for="phone_display">Phone (display text) *</label>
                <input type="text" name="phone_display" id="phone_display" value="{{ old('phone_display', $content['phone_display']) }}" required>
            </div>
            <div class="form-group">
                <label for="phone_tel">Phone (for tel: link, e.g. +61421670636) *</label>
                <input type="text" name="phone_tel" id="phone_tel" value="{{ old('phone_tel', $content['phone_tel']) }}" required>
            </div>
            <div class="form-group">
                <label for="instagram_url">Instagram URL *</label>
                <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $content['instagram_url']) }}" required>
            </div>
            <div class="form-group">
                <label for="instagram_display">Instagram (display text) *</label>
                <input type="text" name="instagram_display" id="instagram_display" value="{{ old('instagram_display', $content['instagram_display']) }}" required>
            </div>

            <hr style="border:none; border-top:1px solid #e2e8f0; margin:1.25rem 0;">

            <h3 style="margin-top:0;">Lead form header</h3>
            <div class="form-group">
                <label for="section_label">Small label above heading *</label>
                <input type="text" name="section_label" id="section_label" value="{{ old('section_label', $content['section_label']) }}" required>
            </div>
            <div class="form-group">
                <label for="page_heading">Page heading *</label>
                <input type="text" name="page_heading" id="page_heading" value="{{ old('page_heading', $content['page_heading']) }}" required>
            </div>
            <div class="form-group">
                <label for="form_headline">Form headline *</label>
                <input type="text" name="form_headline" id="form_headline" value="{{ old('form_headline', $content['form_headline']) }}" required>
            </div>
            <div class="form-group">
                <label for="form_intro">Form intro *</label>
                <textarea name="form_intro" id="form_intro" required>{{ old('form_intro', $content['form_intro']) }}</textarea>
            </div>

            <button type="submit" class="admin-btn">Save Contact page</button>
        </form>
    </div>
@endsection
