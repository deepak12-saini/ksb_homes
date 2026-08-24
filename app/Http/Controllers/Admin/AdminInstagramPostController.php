<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramPost;
use App\Services\InstagramThumbnailService;
use App\Support\InstagramEmbedParser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class AdminInstagramPostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $posts = InstagramPost::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('admin_note', 'like', '%'.$search.'%')
                        ->orWhere('instagram_url', 'like', '%'.$search.'%');
                });
            })
            ->orderByDesc('sort_order')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.instagram-posts.index', [
            'posts' => $posts,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.instagram-posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'embed_input' => ['required', 'string', 'max:10000'],
            'admin_note' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        try {
            $parsed = InstagramEmbedParser::parse($validated['embed_input']);
        } catch (InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->withErrors(['embed_input' => $e->getMessage()]);
        }

        InstagramPost::create([
            'instagram_url' => $parsed['instagram_url'],
            'embed_code' => $parsed['embed_code'],
            'thumbnail_url' => app(InstagramThumbnailService::class)->storeLocalThumbnail($parsed['instagram_url']),
            'admin_note' => $validated['admin_note'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.instagram-posts.index')->with('success', 'Instagram post created.');
    }

    public function edit(InstagramPost $instagramPost): View
    {
        return view('admin.instagram-posts.edit', [
            'post' => $instagramPost,
        ]);
    }

    public function update(Request $request, InstagramPost $instagramPost): RedirectResponse
    {
        $validated = $request->validate([
            'embed_input' => ['nullable', 'string', 'max:10000'],
            'admin_note' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $update = [
            'admin_note' => $validated['admin_note'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? $instagramPost->sort_order,
        ];

        if (! empty($validated['embed_input'])) {
            try {
                $parsed = InstagramEmbedParser::parse($validated['embed_input']);
            } catch (InvalidArgumentException $e) {
                return back()
                    ->withInput()
                    ->withErrors(['embed_input' => $e->getMessage()]);
            }

            $update['instagram_url'] = $parsed['instagram_url'];
            $update['embed_code'] = $parsed['embed_code'];
            $update['thumbnail_url'] = app(InstagramThumbnailService::class)->storeLocalThumbnail(
                $parsed['instagram_url'],
                $instagramPost->thumbnail_url
            );
        }

        $instagramPost->update($update);

        $fresh = $instagramPost->fresh();
        if ($fresh && ! $fresh->hasLocalThumbnail()) {
            $thumbnail = app(InstagramThumbnailService::class)->storeLocalThumbnail(
                $fresh->instagram_url,
                $fresh->thumbnail_url
            );
            if ($thumbnail) {
                $fresh->update(['thumbnail_url' => $thumbnail]);
            }
        }

        return redirect()->route('admin.instagram-posts.edit', $instagramPost)->with('success', 'Instagram post updated.');
    }

    public function destroy(InstagramPost $instagramPost): RedirectResponse
    {
        $instagramPost->delete();

        return redirect()->route('admin.instagram-posts.index')->with('success', 'Instagram post deleted.');
    }

    public function refreshThumbnail(InstagramPost $instagramPost): RedirectResponse
    {
        $thumbnailPath = app(InstagramThumbnailService::class)->storeLocalThumbnail(
            $instagramPost->instagram_url,
            $instagramPost->thumbnail_url
        );

        if ($thumbnailPath) {
            $instagramPost->update(['thumbnail_url' => $thumbnailPath]);

            return back()->with('success', 'Thumbnail downloaded and saved locally.');
        }

        return back()->withErrors([
            'embed_input' => 'Could not download thumbnail from Instagram. Check the post URL is public, then try Refresh thumbnail again.',
        ]);
    }
}
