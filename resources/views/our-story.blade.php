@extends('layout')

@section('title', $storyContent['seo_title'])
@section('meta_description', $storyContent['seo_description'])
@section('canonical', route('our-story'))

@section('content')
    @php
        $placeholder = 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=500&fit=crop';
        $defaultHeroImg = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&h=900&fit=crop';
        $heroImage = !empty($storyContent['hero_image'])
            ? asset('storage/'.$storyContent['hero_image'])
            : $defaultHeroImg;
        $defaultVision = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=900&h=560&fit=crop&q=80';
        $visionImage = !empty($storyContent['vision_image'])
            ? asset('storage/'.$storyContent['vision_image'])
            : (is_file(public_path('assets/images/our-story-vision.jpg'))
                ? asset('assets/images/our-story-vision.jpg')
                : $defaultVision);
        $defaultFounders = 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=900&h=560&fit=crop&q=80';
        $foundersImage = !empty($storyContent['founders_image'])
            ? asset('storage/'.$storyContent['founders_image'])
            : (is_file(public_path('assets/images/our-story-founders.jpg'))
                ? asset('assets/images/our-story-founders.jpg')
                : $defaultFounders);
    @endphp

    {{-- Hero: full-width image, "About" label, large heading --}}
    <section class="story-hero story-hero--motion" aria-label="Our Story">
        <div class="story-hero__bg">
            {{-- Replace with asset('assets/images/our-story-hero.jpg') for your own image --}}
            <img src="{{ $heroImage }}" alt="" class="story-hero__img">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="story-hero__content">
            <p class="story-hero__label">{{ $storyContent['hero_label'] }}</p>
            <h1 class="story-hero__title">{{ $storyContent['hero_title'] }}</h1>
        </div>
    </section>

    {{-- Vision: copy + image (replace demo: add public/assets/images/our-story-vision.jpg) --}}
    <section class="section section--about story-content story-content--vision" aria-labelledby="vision-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <div class="story-vision__grid">
                <div class="story-vision__copy">
                    <h2 id="vision-heading" class="story-content__heading">{{ $storyContent['vision_heading'] }}</h2>
                    <div class="section__content">
                        <p>{{ $storyContent['vision_paragraph_1'] }}</p>
                        <p>{{ $storyContent['vision_paragraph_2'] }}</p>
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

    {{-- Founders: copy + portrait or leadership image (replace demo: public/assets/images/our-story-founders.jpg) --}}
    <section class="section section--about story-content story-content--founders" aria-labelledby="founders-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <div class="story-founders__grid">
                <div class="story-founders__copy">
                    <h2 id="founders-heading" class="story-content__heading">{{ $storyContent['founders_heading'] }}</h2>
                    <div class="section__content">
                        <p>{{ $storyContent['founders_paragraph_1'] }}</p>
                    </div>
                </div>
                <figure class="story-founders__figure">
                    <div class="story-founders__media">
                        <img src="{{ $foundersImage }}" alt="KSB Homes founders leading design and construction direction" class="story-founders__img" width="900" height="560" loading="lazy">
                    </div>
                </figure>
            </div>
        </div>
    </section>

    @php
        $storyStats = [
            [
                'value' => (int) ($storyContent['stat_1_value'] ?? 12),
                'suffix' => (string) ($storyContent['stat_1_suffix'] ?? ''),
                'label' => $storyContent['stat_1_label'] ?? 'Years of Experience',
            ],
            [
                'value' => (int) ($storyContent['stat_2_value'] ?? 60),
                'suffix' => (string) ($storyContent['stat_2_suffix'] ?? '+'),
                'label' => $storyContent['stat_2_label'] ?? 'Projects Completed',
            ],
            [
                'value' => (int) ($storyContent['stat_3_value'] ?? 31),
                'suffix' => (string) ($storyContent['stat_3_suffix'] ?? ''),
                'label' => $storyContent['stat_3_label'] ?? 'Awards',
            ],
        ];
    @endphp

    {{-- Stats: scroll-triggered counters below founders --}}
    <section class="story-stats" aria-label="Company achievements" data-story-stats>
        <div class="section__inner">
            <div class="story-stats__grid">
                @foreach ($storyStats as $stat)
                    <div class="story-stats__item">
                        <p class="story-stats__value" aria-label="{{ $stat['value'].$stat['suffix'].' '.$stat['label'] }}">
                            <span
                                class="story-stats__number"
                                data-count-to="{{ $stat['value'] }}"
                                data-count-suffix="{{ $stat['suffix'] }}"
                            >0{{ $stat['suffix'] }}</span>
                        </p>
                        <p class="story-stats__label">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services section (like reference layout) --}}
    <section class="section section--about story-content" aria-labelledby="services-heading">
        <div class="section__inner">
            <hr class="story-content__divider">
            <h2 id="services-heading" class="story-content__heading">{{ $storyContent['services_heading'] }}</h2>
            <div class="section__content">
                <p>{{ $storyContent['services_intro'] }}</p>
            </div>

            <div class="services-grid">
                <div class="services-grid__row">
                    <div class="services-grid__label">{{ $storyContent['services_architecture_label'] }}</div>
                    <div class="services-grid__text">{{ $storyContent['services_architecture_text'] }}</div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">{{ $storyContent['services_development_label'] }}</div>
                    <div class="services-grid__text">{{ $storyContent['services_development_text'] }}</div>
                </div>
                <div class="services-grid__row">
                    <div class="services-grid__label">{{ $storyContent['services_construction_label'] }}</div>
                    <div class="services-grid__text">{{ $storyContent['services_construction_text'] }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    var root = document.querySelector('[data-story-stats]');
    if (!root) return;

    var numbers = root.querySelectorAll('[data-count-to]');
    if (!numbers.length) return;

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function setFinal(el) {
        var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
        var suffix = el.getAttribute('data-count-suffix') || '';
        el.textContent = String(target) + suffix;
    }

    function animate(el) {
        var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
        var suffix = el.getAttribute('data-count-suffix') || '';
        if (reducedMotion || target <= 0) {
            setFinal(el);
            return;
        }

        var duration = Math.min(1800, 900 + target * 12);
        var start = null;

        function frame(ts) {
            if (start === null) start = ts;
            var progress = Math.min(1, (ts - start) / duration);
            // Ease-out cubic
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = Math.round(target * eased);
            el.textContent = String(current) + suffix;
            if (progress < 1) {
                requestAnimationFrame(frame);
            } else {
                setFinal(el);
            }
        }

        requestAnimationFrame(frame);
    }

    if (!('IntersectionObserver' in window)) {
        numbers.forEach(setFinal);
        return;
    }

    var played = false;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting || played) return;
            played = true;
            numbers.forEach(animate);
            observer.disconnect();
        });
    }, { threshold: 0.35 });

    observer.observe(root);
})();
</script>
@endpush
