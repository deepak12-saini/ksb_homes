@extends('layout')

@section('title', 'Our Story – KSB homes Design + Construct')
@section('meta_description', 'Learn about KSB homes – award-winning design, development, and construction in Brisbane, Gold Coast and Byron Bay.')

@section('content')
    {{-- Hero: full-width image, "About" label, large heading --}}
    <section class="story-hero" aria-label="Our Story">
        <div class="story-hero__bg">
            {{-- Replace with asset('assets/images/our-story-hero.jpg') for your own image --}}
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&h=900&fit=crop" alt="" class="story-hero__img">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="story-hero__content">
            <p class="story-hero__label">About</p>
            <h1 class="story-hero__title">Visionary design and construction excellence</h1>
        </div>
    </section>

    {{-- Content: divider, Vision heading, paragraphs --}}
    <section class="section section--about story-content" aria-labelledby="vision-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="vision-heading" class="story-content__heading">Vision</h2>
            <div class="section__content">
                <p>KSB homes is an award-winning design, development, and construction company specialising in luxury residential projects in the blue-chip suburbs of Brisbane, the Gold Coast and Byron Bay.</p>
                <p>Our goal is to create exceptional projects that set new benchmarks for luxury living. We are focused on taking the premium residential sector to new heights by delivering game-changing projects underpinned by visionary design and construction excellence.</p>
            </div>
        </div>
    </section>


    <section class="section section--two-col" aria-label="Our Story visuals">
        <div class="section__inner section__inner--relative">
            <div class="two-col__grid">
                <div class="two-col__left">
                    <img src="{{ asset('assets/images/ceo.png') }}" alt="Our team" class="two-col__img" width="700" height="900">
                </div>
                <div class="two-col__right">
                    <img src="{{ asset('assets/images/2.jpg') }}" alt="Exclusive project" class="two-col__img" width="500" height="900">
                </div>
            </div>
            <p class="two-col__badge">Ksb Exclusive Access</p>
        </div>
    </section>

    <section class="section section--feature-img" aria-label="Exclusive project">
        <div class="feature-img__wrap">
            <img src="{{ asset('assets/images/3.jpg') }}" alt="Exclusive residential project" class="feature-img__img" width="1200" height="800">
            <p class="feature-img__badge">Ksb Exclusive Access</p>
        </div>
    </section>

    <section class="section section--about story-content" aria-labelledby="founders-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="founders-heading" class="story-content__heading">Founders</h2>
            <div class="section__content">
                <p>KSB Homes is a dedicated construction and home building company focused on delivering quality residential projects.</p>
                <p>Our team is committed to excellence, innovation, and attention to detail in every project we undertake. We aim to create modern, comfortable homes while maintaining the highest standards of workmanship and reliability.</p>
            </div>
        </div>
    </section>

    {{-- Services section (like reference layout) --}}
    <section class="section section--about story-content" aria-labelledby="services-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="services-heading" class="story-content__heading">Services</h2>
            <div class="section__content">
                <p>Our in-house design, development and construction expertise enable us to ensure high-quality projects of superior design and innovative craftsmanship, from concept design to project delivery.</p>
            </div>

            <div class="services-grid">
                <div class="services-grid__row">
                    <div class="services-grid__label">Architecture</div>
                    <div class="services-grid__text">
                        Ksb homes has access to an experienced in-house design team comprising of some of Brisbane’s most promising architects. Should you commission Graya to undertake your project, our in-house team will work with you to design a home suited to your specific lifestyle requirements.
                        Our integrated design and construction service allows you to have your project managed by us from start to finish, avoiding the usual hassles associated with engaging a separate architect and builder.
                    </div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">Development</div>
                    <div class="services-grid__text">
                        Our full-service development offering encompasses both residential and multi-residential projects. Our development team aims to secure some of the best development sites in southeast Queensland for our clients and development projects. Our comprehensive development services include but are not limited to land acquisition, design, value management, statutory approvals and project management.
                    </div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">Construction</div>
                    <div class="services-grid__text">
                        Our construction team manages projects from concept to completion, coordinating trades, quality control and on-site delivery. We focus on buildability, program and detail to ensure every home is delivered to a high standard, on time and with minimal disruption.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
