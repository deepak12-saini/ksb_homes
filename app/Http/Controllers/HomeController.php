<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Models\PageContent;
use App\Models\Project;
use App\Services\InstagramFeedService;
use App\Services\InstagramThumbnailService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public const INSTAGRAM_INITIAL_VISIBLE = 12;

    public const INSTAGRAM_MAX_VISIBLE = 30;

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

        $instagramProfileUrl = config('services.instagram.profile_url', 'https://www.instagram.com/ksbhomes_/');
        $instagramHandle = $this->instagramHandleFromUrl($instagramProfileUrl);

        $instagramFeedPosts = InstagramPost::query()
            ->active()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit(self::INSTAGRAM_MAX_VISIBLE)
            ->get();

        $thumbnailService = app(InstagramThumbnailService::class);
        foreach ($instagramFeedPosts as $post) {
            if ($post->thumbnail_url) {
                continue;
            }

            $thumbnailUrl = $thumbnailService->fetchThumbnailUrl($post->instagram_url);
            if ($thumbnailUrl) {
                $post->update(['thumbnail_url' => $thumbnailUrl]);
                $post->thumbnail_url = $thumbnailUrl;
            }
        }

        return view('home', [
            'featuredProjects' => $featuredProjects,
            'homeContent' => PageContent::getPageValues('home', $homeContentDefaults),
            'instagramFeedPosts' => $instagramFeedPosts,
            'instagramFallbackPosts' => $instagramFeedPosts->isNotEmpty()
                ? collect()
                : app(InstagramFeedService::class)->latestPosts(self::INSTAGRAM_MAX_VISIBLE),
            'instagramProfileUrl' => $instagramProfileUrl,
            'instagramHandle' => $instagramHandle,
            'instagramInitialVisible' => self::INSTAGRAM_INITIAL_VISIBLE,
            'instagramMaxVisible' => self::INSTAGRAM_MAX_VISIBLE,
        ]);
    }

    private function instagramHandleFromUrl(string $url): string
    {
        if (preg_match('~instagram\.com/([^/?#]+)~i', $url, $matches)) {
            return '@'.ltrim($matches[1], '@');
        }

        return '@ksbhomes_';
    }
}
