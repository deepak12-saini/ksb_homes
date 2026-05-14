@extends('layout')

@section('title', $project->name . ' – KSB homes')
@section('meta_description', 'Discover ' . $project->name . ' by KSB homes, a luxury residential project on Sydney\'s North Shore.')
@section('canonical', route('projects.show', $project))
@if ($project->public_image_url)
    @section('og_image', $project->public_image_url)
@endif

@php
    $projectHeroImage = $project->public_image_url
        ?? 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&h=900&fit=crop';
@endphp

@section('content')
    <article class="project-detail" aria-labelledby="project-heading">
        <div class="project-detail__nav">
            <a href="{{ route('projects.index') }}" class="project-detail__back">Projects</a>
        </div>
        <div class="project-detail__grid">
            <div class="project-detail__media" @if (! $project->image) aria-hidden="true" @endif>
                <img
                    src="{{ $projectHeroImage }}"
                    alt="{{ $project->image ? $project->name : '' }}"
                    class="project-detail__img"
                    width="900"
                    height="1100"
                    loading="eager"
                    @if (! $project->image) role="presentation" @endif
                >
            </div>
            <div class="project-detail__panel">
                <p class="project-detail__label">{{ $project->category->name ?? 'Project' }}</p>
                <h1 id="project-heading" class="project-detail__title">{{ $project->name }}</h1>
                <dl class="project-detail__meta">
                    @if (filled($project->architecture))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">Architecture</dt>
                            <dd class="project-detail__value">{{ $project->architecture }}</dd>
                        </div>
                    @endif
                    @if (filled($project->location))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">Location</dt>
                            <dd class="project-detail__value">{{ $project->location }}</dd>
                        </div>
                    @endif
                    @if (filled($project->status))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">Status</dt>
                            <dd class="project-detail__value">{{ $project->status }}</dd>
                        </div>
                    @endif
                    @if (filled($project->property_type))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">Property type</dt>
                            <dd class="project-detail__value">{{ $project->property_type }}</dd>
                        </div>
                    @endif
                    @if (filled($project->no))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">No.</dt>
                            <dd class="project-detail__value">{{ $project->no }}</dd>
                        </div>
                    @endif
                    @if (filled($project->levels))
                        <div class="project-detail__row">
                            <dt class="project-detail__term">Levels</dt>
                            <dd class="project-detail__value">{{ $project->levels }}</dd>
                        </div>
                    @endif
                </dl>
                <div class="project-detail__actions">
                    <a href="{{ route('contact.index') }}" class="btn btn--primary project-detail__enquire">Enquire</a>
                    @if ($nextProject)
                        <a
                            href="{{ route('projects.show', $nextProject) }}"
                            class="project-detail__next"
                            aria-label="Next project: {{ $nextProject->name }}"
                        >
                            <span class="project-detail__next-arrow" aria-hidden="true">→</span>
                            Next Project
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </article>
@endsection
