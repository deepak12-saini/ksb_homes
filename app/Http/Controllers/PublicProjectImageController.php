<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves uploaded project images via Laravel so they work when public/storage symlink
 * is missing, FollowSymLinks is off, or the host blocks direct /storage access (403).
 */
class PublicProjectImageController extends Controller
{
    public function show(string $filename): Response|StreamedResponse
    {
        if (! preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            abort(404);
        }

        $path = 'projects/'.$filename;

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path);
    }
}
