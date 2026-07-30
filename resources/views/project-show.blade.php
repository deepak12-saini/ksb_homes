@extends('layout')

@php
    $projectSeoLocation = $project->location ?: "Sydney's North Shore";
    $projectSeoDescription = trim(implode(' ', array_filter([
        'Discover '.$project->name.' by KSB Luxury Homes.',
        $project->property_type ? $project->property_type.' project' : 'Luxury residential project',
        'in '.$projectSeoLocation.'.',
        $project->architecture ? 'Architecture: '.$project->architecture.'.' : null,
        $project->status ? 'Status: '.$project->status.'.' : null,
    ])));
    $projectHeroImage = $project->public_image_url
        ?? 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&h=900&fit=crop';
    $galleryUrls = $project->allPublicImageUrls();
    $schemaImages = array_map(fn ($url) => url($url), $galleryUrls ?: [$projectHeroImage]);
@endphp

@section('title', $project->name.' | KSB Luxury Homes – '.$projectSeoLocation)
@section('meta_description', \Illuminate\Support\Str::limit($projectSeoDescription, 155, ''))
@section('canonical', route('projects.show', $project))
@section('og_type', 'article')
@section('og_image', url($project->public_image_url ?: $projectHeroImage))

@push('scripts')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Residence',
    'name' => $project->name,
    'description' => $projectSeoDescription,
    'url' => route('projects.show', $project),
    'image' => count($schemaImages) === 1 ? $schemaImages[0] : $schemaImages,
    'address' => array_filter([
        '@type' => 'PostalAddress',
        'addressLocality' => $project->location ?: 'Sydney North Shore',
        'addressRegion' => 'NSW',
        'addressCountry' => 'AU',
    ]),
    'provider' => [
        '@type' => 'Organization',
        'name' => 'KSB Luxury Homes',
        'url' => rtrim(config('app.url'), '/'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    <article class="project-detail" aria-labelledby="project-heading">
        <div class="project-detail__nav">
            <a href="{{ route('projects.index') }}" class="project-detail__back">Projects</a>
        </div>
        <div class="project-detail__grid">
            <div class="project-detail__media" @if ($galleryUrls === []) aria-hidden="true" @endif>
                @if ($galleryUrls === [])
                    <figure class="project-detail__figure">
                        <img
                            src="{{ $projectHeroImage }}"
                            alt=""
                            class="project-detail__img"
                            loading="eager"
                            role="presentation"
                        >
                    </figure>
                @else
                    @foreach ($galleryUrls as $index => $imageUrl)
                        <figure class="project-detail__figure">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $project->name }}{{ count($galleryUrls) > 1 ? ' – view '.($index + 1) : '' }}"
                                class="project-detail__img"
                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                @if ($index === 0) fetchpriority="high" @endif
                            >
                        </figure>
                    @endforeach
                @endif
            </div>
            <aside class="project-detail__panel">
                <div class="project-detail__panel-inner">
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
            </aside>
        </div>
    </article>
@endsection
