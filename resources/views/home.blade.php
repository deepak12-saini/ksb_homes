@extends('layout')

@section('title', 'KSB HOMES Design + Construct – Turning Dreams Into Reality')
@section('meta_description', "KSB Luxury Homes – high-end design, development and construction for luxury residential projects on Sydney's North Shore.")

@section('content')
    @php
        $placeholder = 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop';
        $aboutTeamImage = !empty($homeContent['about_image'])
            ? asset('storage/'.$homeContent['about_image'])
            : (is_file(public_path('assets/images/about-team.jpg'))
                ? asset('assets/images/about-team.jpg')
                : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=900&h=560&fit=crop&q=80');
        /** First two “Show on home” projects: large side-by-side images, names below (no badges). */
        $spotlight = $featuredProjects->take(2);
    @endphp

    {{-- Hero section: full-bleed video with overlaid text (reference: graya.com.au) --}}
    <section class="hero hero--motion" aria-label="Hero">
        <div class="hero__media">
            <video class="hero__video" autoplay muted loop playsinline poster="{{ asset('assets/images/hero-poster.jpg') }}">
                <source src="{{ asset('assets/videos/hero.mp4') }}" type="video/mp4">
            </video>
            <div class="hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="hero__content">
            <h1 class="hero__title">
                <span class="hero__line">{{ $homeContent['hero_title_line_1'] }}</span>
                <span class="hero__line hero__line--2">{{ $homeContent['hero_title_line_2'] }}</span>
            </h1>
            <p class="hero__tagline">{{ $homeContent['hero_tagline'] }}</p>
        </div>
    </section>

    {{-- About section: copy + team image (replace demo: add public/assets/images/about-team.jpg) --}}
    <section id="about" class="section section--about section--about-home" aria-labelledby="about-heading">
        <div class="section__inner section__inner--about-home">
            <div class="about-home__copy">
                <p class="section__label">For KSB</p>
                <h2 id="about-heading" class="section__title">About KSB Luxury Homes</h2>
                <div class="section__content">
                    <p>{{ $homeContent['about_paragraph_1'] }}</p>
                    <p>{{ $homeContent['about_paragraph_2'] }}</p>
                    <p>{{ $homeContent['about_paragraph_3'] }}</p>
                    <p>{{ $homeContent['about_paragraph_4'] }}</p>
                    <a href="{{ route('our-story') }}" class="btn btn--primary">Our Story</a>
                </div>
            </div>
            <figure class="about-home__figure">
                <div class="about-home__media">
                    <img src="{{ $aboutTeamImage }}" alt="KSB team on site with a luxury home build" class="about-home__img" width="900" height="560" loading="lazy">
                </div>
            </figure>
        </div>
    </section>

    {{-- Two featured projects: large cards + same hover treatment as /projects listing --}}
    @if ($spotlight->isNotEmpty())
        <section class="section section--two-col section--home-spotlight" aria-label="Featured projects">
            <div class="section__inner section__inner--relative">
                <div class="home-spotlight__grid {{ $spotlight->count() === 1 ? 'home-spotlight__grid--single' : '' }}">
                    @foreach ($spotlight as $project)
                        <a href="{{ route('projects.show', $project) }}" class="home-spotlight__card">
                            <div class="home-spotlight__img-wrap">
                                @if ($project->image)
                                    <img src="{{ $project->public_image_url }}" alt="{{ $project->name }}" class="home-spotlight__img" width="700" height="900" loading="lazy">
                                @else
                                    <img src="{{ $placeholder }}" alt="{{ $project->name }}" class="home-spotlight__img" width="700" height="900" loading="lazy">
                                @endif
                                <span class="project-card__hover-overlay" aria-hidden="true"></span>
                                <span class="project-card__hover-mark" aria-hidden="true">KSB LUXURY HOMES</span>
                                <span class="project-card__hover-cta" aria-hidden="true">View project</span>
                                <span class="project-card__title">{{ $project->name }}</span>
                            </div>
                            <span class="project-card__caption project-card__caption--spotlight" aria-hidden="true">{{ $project->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- All featured projects: names under images in grid --}}
    <section id="collection" class="section section--collection section--home-collection" aria-labelledby="collection-heading">
        <div class="section__inner">
            <p class="section__label">Collection</p>
            <h2 id="collection-heading" class="section__title">Projects</h2>
            @php
                $count = $featuredProjects->count();
                $gridClass = 'projects-grid';
                if ($count >= 1 && $count <= 2) {
                    $gridClass .= ' projects-grid--pair';
                } elseif ($count > 2) {
                    $gridClass .= ' projects-grid--home-many';
                }
            @endphp
            @if ($featuredProjects->isNotEmpty())
                <div class="{{ $gridClass }}">
                    @foreach ($featuredProjects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="project-card project-card--stacked">
                            <div class="project-card__media">
                                @if ($project->image)
                                    <img src="{{ $project->public_image_url }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                                @else
                                    <img src="{{ $placeholder }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                                @endif
                                <span class="project-card__hover-overlay" aria-hidden="true"></span>
                                <span class="project-card__hover-mark" aria-hidden="true">KSB LUXURY HOMES</span>
                                <span class="project-card__hover-cta" aria-hidden="true">View project</span>
                                <span class="project-card__title">{{ $project->name }}</span>
                            </div>
                            <span class="project-card__caption" aria-hidden="true">{{ $project->name }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="collection-empty collection-empty--home" style="grid-column: 1 / -1;">No featured projects yet. Add projects in the admin and tick &ldquo;Show on home page&rdquo;.</p>
            @endif

            <div class="projects-grid__action">
                <a href="{{ url('/projects') }}" class="btn btn--primary">View Collection</a>
            </div>
        </div>
    </section>
@endsection
