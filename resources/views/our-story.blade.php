@extends('layout')

@section('title', 'Our Story – KSB homes Design + Construct')
@section('meta_description', 'Learn about KSB homes – award-winning design, development, and construction.')

@section('content')
    @php
        $placeholder = 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop';
        $visionImage = is_file(public_path('assets/images/our-story-vision.jpg'))
            ? asset('assets/images/our-story-vision.jpg')
            : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=900&h=560&fit=crop&q=80';
    @endphp

    {{-- Hero: full-width image, "About" label, large heading --}}
    <section class="story-hero story-hero--motion" aria-label="Our Story">
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

    {{-- Vision: copy + image (replace demo: add public/assets/images/our-story-vision.jpg) --}}
    <section class="section section--about story-content story-content--vision" aria-labelledby="vision-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <div class="story-vision__grid">
                <div class="story-vision__copy">
                    <h2 id="vision-heading" class="story-content__heading">Vision</h2>
                    <div class="section__content">
                        <p>KSB homes is an award-winning design, development, and construction company specialising in luxury residential projects.</p>
                        <p>Our goal is to create exceptional projects that set new benchmarks for luxury living.</p>
                    </div>
                </div>
                <figure class="story-vision__figure">
                    <div class="story-vision__media">
                        <img src="{{ $visionImage }}" alt="Luxury residential architecture reflecting award-winning design and benchmarks for luxury living" class="story-vision__img" width="900" height="560" loading="lazy">
                    </div>
                </figure>
            </div>
        </div>
    </section>


    {{-- Same as home: first two “Show on home” projects, names below images (no badges) --}}
    @if ($spotlightProjects->isNotEmpty())
        <section class="section section--two-col section--home-spotlight" aria-label="Featured projects">
            <div class="section__inner section__inner--relative">
                <div class="home-spotlight__grid {{ $spotlightProjects->count() === 1 ? 'home-spotlight__grid--single' : '' }}">
                    @foreach ($spotlightProjects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="home-spotlight__card">
                            <div class="home-spotlight__img-wrap">
                                @if ($project->image)
                                    <img src="{{ $project->public_image_url }}" alt="{{ $project->name }}" class="home-spotlight__img" width="700" height="900" loading="lazy">
                                @else
                                    <img src="{{ $placeholder }}" alt="{{ $project->name }}" class="home-spotlight__img" width="700" height="900" loading="lazy">
                                @endif
                            </div>
                            <p class="home-spotlight__name">{{ $project->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section section--about story-content" aria-labelledby="founders-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="founders-heading" class="story-content__heading">Founders</h2>
            <div class="section__content">
                <p>KSB Homes is a dedicated construction and home building company focused on delivering quality residential projects.</p>
            </div>
        </div>
    </section>

    {{-- Services section (like reference layout) --}}
    <section class="section section--about story-content" aria-labelledby="services-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="services-heading" class="story-content__heading">Services</h2>
            <div class="section__content">
                <p>Architecture, development, and construction—delivered with a single vision from concept to completion.</p>
            </div>

            <div class="services-grid">
                <div class="services-grid__row">
                    <div class="services-grid__label">Architecture</div>
                    <div class="services-grid__text">Concept design, documentation, and coordination tailored to luxury residential outcomes.</div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">Development</div>
                    <div class="services-grid__text">Residential and multi-residential development—from site strategy through approvals and delivery.</div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">Construction</div>
                    <div class="services-grid__text">On-site delivery, quality control, and program management to complete your project to a high standard.</div>
                </div>
            </div>
        </div>
    </section>
@endsection
