@extends('layout')

@section('title', 'Contact – KSB homes Design + Construct')
@section('meta_description', 'Get in touch with KSB homes about our services and luxury residential projects.')

@section('content')

    <section class="story-hero" aria-label="Contact">
        <div class="story-hero__bg">
            @php
                $contactHeroCandidates = ['contact-hero.jpg', 'contact-hero.jpeg', 'contact-hero.webp'];
                $contactHeroUrl = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&h=900&fit=crop';
                foreach ($contactHeroCandidates as $file) {
                    if (file_exists(public_path('assets/images/' . $file))) {
                        $contactHeroUrl = asset('assets/images/' . $file);
                        break;
                    }
                }
            @endphp
            <img src="{{ $contactHeroUrl }}" alt="Luxury residential architecture" class="story-hero__img" width="1600" height="900">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
    </section>

    <section class="contact-details-bar" aria-label="Address and contact">
        <div class="contact-details-bar__inner">
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Address</span>
                <span class="contact-details-bar__value">Wahroonga Sydney NSW</span>
            </div>
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Phone</span>
                <a href="tel:+61421670636" class="contact-details-bar__value contact-details-bar__link">0421670636</a>
            </div>
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Instagram</span>
                <a href="https://www.instagram.com/ksbhomes/" class="contact-details-bar__value contact-details-bar__link" target="_blank" rel="noopener noreferrer">@ksbhomes</a>
            </div>
        </div>
    </section>

    <section class="section section--page section--about contact-page" aria-labelledby="contact-heading">
        <div class="section__inner contact-grid">
            <div class="contact-info">
                <p class="section__label">Contact</p>
                <h1 id="contact-heading" class="section__title section__title--small">Enquire Now</h1>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Address</h2>
                    <p class="contact-info__text">Wahroonga Sydney NSW</p>
                </div>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Phone</h2>
                    <p class="contact-info__text"><a href="tel:+61421670636">0421670636</a></p>
                </div>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Instagram</h2>
                    <p class="contact-info__text"><a href="https://www.instagram.com/ksbhomes/" target="_blank" rel="noopener noreferrer">@ksbhomes</a></p>
                </div>
            </div>

            <div class="contact-form">
                <p class="contact-form__intro">
                    If you would like to contact KSB homes, please reach out using the form below.
                </p>

                @if (session('contact_success'))
                    <p class="contact-form__message contact-form__message--success">
                        {{ session('contact_success') }}
                    </p>
                @endif

                <form method="post" action="{{ route('contact.submit') }}" class="contact-form__form" novalidate>
                    @csrf

                    <div class="contact-form__field">
                        <label for="enquiry_type" class="contact-form__label">Enquiry Type *</label>
                        <select id="enquiry_type" name="enquiry_type" class="contact-form__input">
                            <option value="">Select an enquiry type</option>
                            <option value="General enquiry" {{ old('enquiry_type') === 'General enquiry' ? 'selected' : '' }}>General enquiry</option>
                            <option value="Project enquiry" {{ old('enquiry_type') === 'Project enquiry' ? 'selected' : '' }}>Project enquiry</option>
                            <option value="Careers" {{ old('enquiry_type') === 'Careers' ? 'selected' : '' }}>Careers</option>
                        </select>
                        @error('enquiry_type')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="first_name" class="contact-form__label">First Name *</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" class="contact-form__input" placeholder="Enter your first name">
                        @error('first_name')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="last_name" class="contact-form__label">Last Name *</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" class="contact-form__input" placeholder="Enter your last name">
                        @error('last_name')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="phone" class="contact-form__label">Phone Number *</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="contact-form__input" placeholder="Enter your phone number">
                        @error('phone')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="email" class="contact-form__label">Email Address *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="contact-form__input" placeholder="Enter your email address">
                        @error('email')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="postcode" class="contact-form__label">Postcode *</label>
                        <input id="postcode" type="text" name="postcode" value="{{ old('postcode') }}" class="contact-form__input" placeholder="Enter your postcode">
                        @error('postcode')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field">
                        <label for="message" class="contact-form__label">Message</label>
                        <textarea id="message" name="message" rows="4" class="contact-form__input contact-form__textarea" placeholder="Your message">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="contact-form__field contact-form__field--checkbox">
                        <label class="contact-form__checkbox-label">
                            <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }}>
                            I consent to receive updates about KSB homes products and services.
                        </label>
                    </div>

                    <button type="submit" class="btn btn--primary contact-form__submit">Submit Enquiry</button>
                </form>
            </div>
        </div>
    </section>
@endsection
