<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Services\InstagramThumbnailService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicInstagramImageController extends Controller
{
    public function show(InstagramPost $instagramPost): RedirectResponse|BinaryFileResponse
    {
        if ($instagramPost->thumbnail_url) {
            return redirect()->away($instagramPost->thumbnail_url);
        }

        $thumbnailUrl = app(InstagramThumbnailService::class)->fetchThumbnailUrl($instagramPost->instagram_url);

        if ($thumbnailUrl) {
            $instagramPost->update(['thumbnail_url' => $thumbnailUrl]);

            return redirect()->away($thumbnailUrl);
        }

        return response()->file(public_path('assets/images/instagram-placeholder.svg'));
    }
}
