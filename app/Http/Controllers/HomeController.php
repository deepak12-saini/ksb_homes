<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Models\PageContent;
use App\Models\Project;
use App\Services\InstagramFeedService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProjects = Project::query()
            ->where('featured_on_home', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $homeContentDefaults = [
            'seo_title' => 'KSB Luxury Homes | Design, Development & Construction – Sydney North Shore',
            'seo_description' => 'KSB Luxury Homes designs, develops and constructs premium residential projects across Sydney\'s North Shore. Luxury homes built with local craftsmanship and vision.',
            'hero_title_line_1' => 'BUILDING',
            'hero_title_line_2' => 'DREAM HOMES',
            'hero_tagline' => 'KSB Luxury Homes — Barker and Knox alumni building luxury homes on the North Shore.',
            'about_paragraph_1' => "KSB Luxury Homes is a high-end design, development and construction company specialising in luxury residential projects across the blue chip suburbs of Sydney's North Shore.",
            'about_paragraph_2' => "Founded and led by alumni of Barker College and Knox Grammar, two of the North Shore's most prestigious institutions, we're not just building in this area—we grew up here. We know these streets, these neighbourhoods, and the families who call them home. That local connection runs through everything we do.",
            'about_paragraph_3' => "Our goal is to create exceptional homes that set new benchmarks for luxury living. We take the premium residential sector to new heights by delivering projects underpinned by visionary design, superior craftsmanship, and an unwavering commitment to excellence.",
            'about_paragraph_4' => 'For us, building on the North Shore isn’t just business it’s personal.',
            'about_image' => null,
        ];

        $manualInstagramPosts = InstagramPost::query()
            ->active()
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(8)
            ->get()
            ->map(fn (InstagramPost $post): array => [
                'id' => 'manual-'.$post->id,
                'image' => $post->imageUrl(),
                'permalink' => $post->instagram_url,
                'caption' => $post->caption ?: 'KSB Luxury Homes on Instagram',
                'media_type' => 'IMAGE',
            ]);

        return view('home', [
            'featuredProjects' => $featuredProjects,
            'homeContent' => PageContent::getPageValues('home', $homeContentDefaults),
            'instagramPosts' => $manualInstagramPosts->isNotEmpty()
                ? $manualInstagramPosts
                : app(InstagramFeedService::class)->latestPosts(8),
            'instagramProfileUrl' => config('services.instagram.profile_url', 'https://www.instagram.com/ksbhomes_/'),
        ]);
    }
}
