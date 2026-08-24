<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Services\InstagramThumbnailService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicInstagramImageController extends Controller
{
    public function show(InstagramPost $instagramPost): Response|StreamedResponse|BinaryFileResponse
    {
        $service = app(InstagramThumbnailService::class);
        $path = $service->ensureLocalThumbnail(
            $instagramPost->instagram_url,
            $instagramPost->thumbnail_url
        );

        if ($path && $path !== $instagramPost->thumbnail_url) {
            $instagramPost->update(['thumbnail_url' => $path]);
        }

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->response($path);
        }

        return response()->file(public_path('assets/images/instagram-placeholder.svg'));
    }
}
