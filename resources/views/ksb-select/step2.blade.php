@extends('layout')

@section('title', 'Tell us about your project | KSB SELECT')
@section('meta_description', 'Describe your custom project for KSB homes.')

@section('content')
    <section class="story-hero story-hero--compact" aria-label="KSB SELECT">
        <div class="story-hero__bg">
            <img src="{{ asset('assets/images/3.jpg') }}" alt="" class="story-hero__img">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="story-hero__content">
            <p class="story-hero__label">KSB SELECT</p>
            <h1 class="story-hero__title">Tell us about your project</h1>
        </div>
    </section>

    <section class="section section--page section--about contact-page" aria-labelledby="ksb-step2-heading">
        <div class="section__inner contact-grid contact-grid--single">
            <div class="contact-form">
                <p class="section__label">Step 2 of 2</p>
                <h1 id="ksb-step2-heading" class="section__title section__title--small">Tell us about your project</h1>
                <p class="contact-form__intro">Share your vision, site, timeline or any questions—we’ll review and be in touch.</p>

                <form method="post" action="{{ route('ksb-select.submit') }}" class="contact-form__form" novalidate>
                    @csrf

                    <div class="contact-form__field">
                        <label for="project_description" class="contact-form__label">Project details*</label>
                        <textarea id="project_description" name="project_description" rows="8" class="contact-form__input contact-form__textarea" required placeholder="Tell us about your project">{{ old('project_description') }}</textarea>
                        @error('project_description')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__actions contact-form__actions--split">
                        <a href="{{ route('ksb-select.index') }}" class="btn btn--outline">Back</a>
                        <button type="submit" class="btn btn--primary contact-form__submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
