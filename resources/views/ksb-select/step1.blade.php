@extends('layout')

@section('title', 'KSB SELECT – Custom Projects | KSB homes Design + Construct')
@section('meta_description', 'Tell us about your custom residential project with KSB SELECT.')

@section('content')
    <section class="story-hero story-hero--compact" aria-label="KSB SELECT">
        <div class="story-hero__bg">
            <img src="{{ asset('assets/images/2.jpg') }}" alt="" class="story-hero__img">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="story-hero__content">
            <p class="story-hero__label">KSB SELECT</p>
            <h1 class="story-hero__title">Custom projects</h1>
        </div>
    </section>

    <section class="section section--page section--about contact-page" aria-labelledby="ksb-step1-heading">
        <div class="section__inner contact-grid contact-grid--single">
            <div class="contact-form">
                <p class="section__label">Step 1 of 2</p>
                <h1 id="ksb-step1-heading" class="section__title section__title--small">Your details</h1>
                <p class="contact-form__intro">Please share your basic details. On the next step you can tell us about your project.</p>

                @if (session('ksb_select_success'))
                    <p class="contact-form__message contact-form__message--success">{{ session('ksb_select_success') }}</p>
                @endif

                <form method="post" action="{{ route('ksb-select.step1') }}" class="contact-form__form" novalidate>
                    @csrf

                    <div class="contact-form__field">
                        <label for="first_name" class="contact-form__label">First Name*</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" class="contact-form__input" required>
                        @error('first_name')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="last_name" class="contact-form__label">Last Name*</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" class="contact-form__input" required>
                        @error('last_name')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="email" class="contact-form__label">Email Address*</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="contact-form__input" required>
                        @error('email')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="phone" class="contact-form__label">Phone Number*</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="contact-form__input" required>
                        @error('phone')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="postcode" class="contact-form__label">Postcode</label>
                        <input id="postcode" type="text" name="postcode" value="{{ old('postcode') }}" class="contact-form__input">
                        @error('postcode')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn--primary contact-form__submit">Continue</button>
                </form>
            </div>
        </div>
    </section>
@endsection
