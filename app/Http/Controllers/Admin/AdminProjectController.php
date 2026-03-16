<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with('category')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.projects.index', compact('projects'));
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
            'image' => ['nullable', 'image', 'max:2048'],
            'is_exclusive_access' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_exclusive_access'] = $request->boolean('is_exclusive_access');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug,' . $project->id],
            'project_category_id' => ['required', 'exists:project_categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_exclusive_access' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_exclusive_access'] = $request->boolean('is_exclusive_access');
        $validated['sort_order'] = $validated['sort_order'] ?? $project->sort_order;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }
}
