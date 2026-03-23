@extends('layout')

@section('title', 'KSB HOMES Design + Construct – Turning Dreams Into Reality')
@section('meta_description', 'KSB homes – luxury design, development, and construction on Sydney North Shore. Building dream homes.')

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
            <h2 id="about-heading" class="section__title">KSB homes is a high-end luxury design, development, and construction company specialising in luxury residential projects in the blue-chip suburbs in North Shore Sydney.</h2>
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
            <a href="{{ route('ksb-select.index') }}" class="two-col__badge two-col__badge--link">KSB SELECT – CUSTOM PROJECTS</a>
        </div>
    </section>

    {{-- Full-width feature image: exclusive project / building with badge --}}
    <section class="section section--feature-img" aria-label="Exclusive project">
        <div class="feature-img__wrap">
            <img src="{{ asset('assets/images/3.jpg') }}" alt="Exclusive residential project" class="feature-img__img" width="1200" height="800">
            <a href="{{ route('ksb-select.index') }}" class="feature-img__badge feature-img__badge--link">KSB SELECT – CUSTOM PROJECTS</a>
        </div>
    </section>

    {{-- Collection / Projects section: grid of project cards with overlay titles --}}
    <section id="collection" class="section section--collection" aria-labelledby="collection-heading">
        <div class="section__inner">
            <p class="section__label">Collection</p>
            <h2 id="collection-heading" class="section__title">Projects</h2>
            @php
                $placeholder = 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop';
                $count = $featuredProjects->count();
                $gridClass = 'projects-grid';
                if ($count >= 1 && $count <= 2) {
                    $gridClass .= ' projects-grid--pair';
                } elseif ($count > 2) {
                    $gridClass .= ' projects-grid--home-many';
                }
            @endphp
            <div class="{{ $gridClass }}">
                @forelse ($featuredProjects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="project-card">
                        @if ($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                        @else
                            <img src="{{ $placeholder }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                        @endif
                        <span class="project-card__title">{{ $project->name }}</span>
                        @if ($project->is_exclusive_access)
                            <span class="project-card__badge">KSB SELECT – CUSTOM PROJECTS</span>
                        @endif
                    </a>
                @empty
                    <p class="collection-empty collection-empty--home" style="grid-column: 1 / -1;">No featured projects yet. Add projects in the admin and tick &ldquo;Show on home page&rdquo;.</p>
                @endforelse
            </div>
            
            <div class="projects-grid__action">
                <a href="{{ url('/projects') }}" class="btn btn--primary">View Collection</a>
            </div>
        </div>
    </section>
@endsection
