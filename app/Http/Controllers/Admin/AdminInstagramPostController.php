<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminInstagramPostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $posts = InstagramPost::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('caption', 'like', '%'.$search.'%')
                        ->orWhere('instagram_url', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12)
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
            'caption' => ['nullable', 'string', 'max:500'],
            'image' => ['required', 'image', 'max:5120'],
            'instagram_url' => ['required', 'url', 'max:500'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
        ]);

        $validated['image'] = $request->file('image')->store('instagram-posts', 'public');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        InstagramPost::create($validated);

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
            'caption' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:5120'],
            'instagram_url' => ['required', 'url', 'max:500'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $instagramPost->sort_order;

        if ($request->hasFile('image')) {
            $oldImage = $instagramPost->image;
            $validated['image'] = $request->file('image')->store('instagram-posts', 'public');

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $instagramPost->update($validated);

        return redirect()->route('admin.instagram-posts.edit', $instagramPost)->with('success', 'Instagram post updated.');
    }

    public function destroy(InstagramPost $instagramPost): RedirectResponse
    {
        $instagramPost->delete();

        return redirect()->route('admin.instagram-posts.index')->with('success', 'Instagram post deleted.');
    }
}
