@extends('layout')

@section('title', 'KSB homes Design + Construct – Creating Landmarks')

@section('content')
    {{-- Hero section: full-bleed video with overlaid text (reference: graya.com.au) --}}
    <section class="hero" aria-label="Hero">
        <div class="hero__media">
            <video class="hero__video" autoplay muted loop playsinline poster="{{ asset('assets/images/hero-poster.jpg') }}">
                <source src="{{ asset('assets/videos/hero.mp4') }}" type="video/mp4">
            </video>
            <div class="hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="hero__content">
            <h1 class="hero__title">
                <span class="hero__line">BUILDING</span>
                <span class="hero__line hero__line--2">DREAM HOMES</span>
            </h1>
        </div>
    </section>

    {{-- About section --}}
    <section id="about" class="section section--about" aria-labelledby="about-heading">
        <div class="section__inner">
            <p class="section__label">About</p>
            <h2 id="about-heading" class="section__title">KSB homes is an award-winning design, development, and construction company specialising in luxury residential projects in the blue-chip suburbs of Brisbane, the Gold Coast and Byron Bay</h2>
            <div class="section__content">
                <p>Our goal is to create exceptional projects that set new benchmarks for luxury living. We are focused on taking the premium residential sector to new heights by delivering game-changing projects underpinned by visionary design and construction excellence.</p>
                <a href="{{ url('/our-story') }}" class="btn btn--primary">Our Story</a>
            </div>
        </div>
    </section>

    {{-- Two-column section: Our Story image + architectural image, white background --}}
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

    {{-- Full-width feature image: exclusive project / building with badge --}}
    <section class="section section--feature-img" aria-label="Exclusive project">
        <div class="feature-img__wrap">
            <img src="{{ asset('assets/images/3.jpg') }}" alt="Exclusive residential project" class="feature-img__img" width="1200" height="800">
            <p class="feature-img__badge">Ksb Exclusive Access</p>
        </div>
    </section>

    {{-- Collection / Projects section: grid of project cards with overlay titles --}}
    <section id="collection" class="section section--collection" aria-labelledby="collection-heading">
        <div class="section__inner">
            <p class="section__label">Collection</p>
            <h2 id="collection-heading" class="section__title">Projects</h2>
            <div class="projects-grid">
                @foreach ([
                    ['name' => 'SILK', 'slug' => 'silk', 'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop'],
                    ['name' => 'THE GALLERY', 'slug' => 'the-gallery', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=500&fit=crop'],
                    ['name' => 'ENCLAVE', 'slug' => 'enclave', 'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=400&h=500&fit=crop'],
                    ['name' => 'HEIRLOOM', 'slug' => 'heirloom', 'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=400&h=500&fit=crop'],
                    ['name' => 'THE PAVILION', 'slug' => 'the-pavilion', 'image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=400&h=500&fit=crop'],
                    ['name' => 'ARC', 'slug' => 'arc', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=500&fit=crop'],
                    ['name' => 'JAMES PLACE', 'slug' => 'james-place', 'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=500&fit=crop'],
                    ['name' => 'RIPPLE', 'slug' => 'ripple', 'image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=400&h=500&fit=crop'],
                ] as $project)
                    <a href="{{ url('/projects/' . $project['slug']) }}" class="project-card">
                        <img src="{{ $project['image'] }}" alt="{{ $project['name'] }}" class="project-card__img" width="400" height="500" loading="lazy">
                        <span class="project-card__title">{{ $project['name'] }}</span>
                    </a>
                @endforeach
            </div>
            <div class="projects-grid__action">
                <a href="{{ url('/projects') }}" class="btn btn--primary">View Collection</a>
            </div>
        </div>
    </section>
@endsection
