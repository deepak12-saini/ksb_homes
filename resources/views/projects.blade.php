@extends('layout')

@section('title', 'Projects – KSB homes Design + Construct')
@section('meta_description', 'Explore our portfolio of luxury residential projects.')

@section('content')
    {{-- Hero: full-width image --}}
    <section class="projects-hero" aria-label="Projects">
        <div class="projects-hero__bg">
            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1600&h=700&fit=crop" alt="" class="projects-hero__img">
            <div class="projects-hero__overlay" aria-hidden="true"></div>
        </div>
    </section>

    {{-- Collection: label + filter buttons + grid --}}
    <section class="section section--collection section--collection-page" aria-labelledby="collection-heading">
        <div class="section__inner">
            <div class="collection-header">
                <p class="section__label" id="collection-heading">Collection</p>
                <div class="collection-filters">
                    <a href="{{ route('projects.index') }}" class="collection-filter {{ !request('category') ? 'is-active' : '' }}">All</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('projects.index', ['category' => $cat->slug]) }}" class="collection-filter {{ request('category') === $cat->slug ? 'is-active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
            @php
                $projectsGridClass = 'projects-grid';
                if ($projects->count() === 2) {
                    $projectsGridClass .= ' projects-grid--pair';
                }
            @endphp
            <div class="{{ $projectsGridClass }}">
                @forelse ($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="project-card project-card--listing">
                        <div class="project-card__media">
                            @if ($project->image)
                                <img src="{{ $project->public_image_url }}" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop" alt="{{ $project->name }}" class="project-card__img" width="400" height="500" loading="lazy">
                            @endif
                            <span class="project-card__title">{{ $project->name }}</span>
                        </div>
                        <span class="project-card__caption" aria-hidden="true">{{ $project->name }}</span>
                    </a>
                @empty
                    <p class="collection-empty" style="grid-column: 1 / -1;">No projects in this collection yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
