@extends('layout')

@section('title', 'KSB HOMES Design + Construct – Turning Dreams Into Reality')
@section('meta_description', 'KSB homes – luxury design, development, and construction on Sydney North Shore. Building dream homes.')

@section('content')
    @php
        $placeholder = 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop';
        /** First two “Show on home” projects: large side-by-side images, names below (no badges). */
        $spotlight = $featuredProjects->take(2);
        /** Remaining featured projects in the Collection grid (names below images). */
        $collectionRest = $featuredProjects->slice(2)->values();
    @endphp

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
                <a href="{{ route('our-story') }}" class="btn btn--primary">Our Story</a>
            </div>
        </div>
    </section>

    {{-- Two featured projects from DB: images + names below (no overlay badge) --}}
    @if ($spotlight->isNotEmpty())
        <section class="section section--two-col section--home-spotlight" aria-label="Featured projects">
            <div class="section__inner section__inner--relative">
                <div class="home-spotlight__grid {{ $spotlight->count() === 1 ? 'home-spotlight__grid--single' : '' }}">
                    @foreach ($spotlight as $project)
                        <a href="{{ route('projects.show', $project) }}" class="home-spotlight__card">
                            <div class="home-spotlight__img-wrap">
                                @if ($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="home-spotlight__img" width="700" height="900" loading="lazy">
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

    {{-- Further featured projects (3rd+): names under images in grid --}}
    <section id="collection" class="section section--collection section--home-collection" aria-labelledby="collection-heading">
        <div class="section__inner">
            <p class="section__label">Collection</p>
            <h2 id="collection-heading" class="section__title">Projects</h2>
            @php
                $count = $collectionRest->count();
                $gridClass = 'projects-grid';
                if ($count >= 1 && $count <= 2) {
                    $gridClass .= ' projects-grid--pair';
                } elseif ($count > 2) {
                    $gridClass .= ' projects-grid--home-many';
                }
            @endphp
            @if ($collectionRest->isNotEmpty())
                <div class="{{ $gridClass }}">
                    @foreach ($collectionRest as $project)
                        <a href="{{ route('projects.show', $project) }}" class="project-card project-card--stacked">
                            @if ($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                            @else
                                <img src="{{ $placeholder }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                            @endif
                            <span class="project-card__title">{{ $project->name }}</span>
                        </a>
                    @endforeach
                </div>
            @elseif ($featuredProjects->isEmpty())
                <p class="collection-empty collection-empty--home" style="grid-column: 1 / -1;">No featured projects yet. Add projects in the admin and tick &ldquo;Show on home page&rdquo;.</p>
            @endif

            <div class="projects-grid__action">
                <a href="{{ url('/projects') }}" class="btn btn--primary">View Collection</a>
            </div>
        </div>
    </section>
@endsection
