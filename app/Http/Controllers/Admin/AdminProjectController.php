<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $categoryId = $request->query('category');

        $projects = Project::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%')
                        ->orWhere('location', 'like', '%'.$search.'%');
                });
            })
            ->when(is_numeric($categoryId), fn ($query) => $query->where('project_category_id', (int) $categoryId))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', [
            'projects' => $projects,
            'categories' => ProjectCategory::orderBy('sort_order')->get(),
            'search' => $search,
            'categoryId' => is_numeric($categoryId) ? (int) $categoryId : null,
        ]);
    }

    public function create(): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();

        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'project_category_id' => ['required', 'exists:project_categories,id'],
            'image' => ['nullable', 'image', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'max:5120'],
            'architecture' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'property_type' => ['nullable', 'string', 'max:255'],
            'no' => ['nullable', 'string', 'max:255'],
            'levels' => ['nullable', 'string', 'max:255'],
            'is_exclusive_access' => ['boolean'],
            'featured_on_home' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_exclusive_access'] = $request->boolean('is_exclusive_access');
        $validated['featured_on_home'] = $request->boolean('featured_on_home');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        unset($validated['gallery_images']);

        $project = Project::create($validated);

        $this->storeGalleryUploads($project, $request->file('gallery_images', []));

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project): View
    {
        $project->load('images');
        $categories = ProjectCategory::orderBy('sort_order')->get();

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug,'.$project->id],
            'project_category_id' => ['required', 'exists:project_categories,id'],
            'image' => ['nullable', 'image', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'max:5120'],
            'remove_gallery_images' => ['nullable', 'array'],
            'remove_gallery_images.*' => ['integer'],
            'gallery_order' => ['nullable', 'array'],
            'gallery_order.*' => ['integer'],
            'architecture' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'property_type' => ['nullable', 'string', 'max:255'],
            'no' => ['nullable', 'string', 'max:255'],
            'levels' => ['nullable', 'string', 'max:255'],
            'is_exclusive_access' => ['boolean'],
            'featured_on_home' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // Capture remove/order before update so they are never lost.
        $removeIds = $request->input('remove_gallery_images', []);
        $galleryOrder = $request->input('gallery_order', []);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_exclusive_access'] = $request->boolean('is_exclusive_access');
        $validated['featured_on_home'] = $request->boolean('featured_on_home');
        $validated['sort_order'] = $validated['sort_order'] ?? $project->sort_order;

        if ($request->hasFile('image')) {
            $oldImage = $project->image;
            $validated['image'] = $request->file('image')->store('projects', 'public');

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        unset($validated['gallery_images'], $validated['remove_gallery_images'], $validated['gallery_order']);

        $project->update($validated);

        $this->removeGalleryImages($project, is_array($removeIds) ? $removeIds : []);
        $this->reorderGalleryImages($project, is_array($galleryOrder) ? $galleryOrder : []);
        $this->storeGalleryUploads($project, $request->file('gallery_images', []));

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    /**
     * @param  array<int, UploadedFile|null>|UploadedFile|null  $files
     */
    private function storeGalleryUploads(Project $project, array|UploadedFile|null $files): void
    {
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        if (! is_array($files) || $files === []) {
            return;
        }

        $sortOrder = (int) $project->images()->max('sort_order');

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid()) {
                continue;
            }

            $sortOrder++;

            ProjectImage::create([
                'project_id' => $project->id,
                'path' => $file->store('projects', 'public'),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    /**
     * @param  array<int, mixed>  $ids
     */
    private function removeGalleryImages(Project $project, array $ids): void
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if ($ids === []) {
            return;
        }

        $project->images()
            ->whereIn('id', $ids)
            ->get()
            ->each(function (ProjectImage $image): void {
                $image->delete();
            });
    }

    /**
     * @param  array<int, mixed>  $ids
     */
    private function reorderGalleryImages(Project $project, array $ids): void
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if ($ids === []) {
            return;
        }

        $ownedIds = $project->images()->pluck('id')->map(fn ($id) => (int) $id)->all();

        foreach ($ids as $index => $id) {
            if (! in_array($id, $ownedIds, true)) {
                continue;
            }

            ProjectImage::query()
                ->where('project_id', $project->id)
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
    }
}
