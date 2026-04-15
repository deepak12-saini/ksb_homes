@extends('layout')

@section('title', $project->name . ' – KSB homes')
@section('meta_description', 'Discover ' . $project->name . ' by KSB homes, a luxury residential project on Sydney\'s North Shore.')
@section('canonical', route('projects.show', $project))
@if ($project->public_image_url)
    @section('og_image', $project->public_image_url)
@endif

@section('content')
    <section class="section section--page section--about" aria-labelledby="project-heading">
        <div class="section__inner">
            <p class="section__label">{{ $project->category->name ?? 'Project' }}</p>
            <h1 id="project-heading" class="section__title">{{ $project->name }}</h1>
            @if ($project->image)
                <p style="margin-bottom: 1.5rem;"><img src="{{ $project->public_image_url }}" alt="{{ $project->name }}" style="max-width: 100%; height: auto;"></p>
            @endif
            <a href="{{ route('projects.index') }}" class="btn btn--primary">Back to Projects</a>
        </div>
    </section>
@endsection
