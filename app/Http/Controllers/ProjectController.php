<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();
        $activeCategory = $request->get('category');

        $query = Project::with('category')->orderBy('sort_order')->orderBy('name');

        if ($activeCategory) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $activeCategory));
        }

        $projects = $query->get();

        return view('projects', [
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'projects' => $projects,
        ]);
    }

    public function show(Project $project): View
    {
        $ids = Project::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->orderBy('id')
            ->pluck('id');

        $index = $ids->search($project->getKey());
        $nextProject = null;

        if ($ids->isNotEmpty() && $index !== false && $ids->count() > 1) {
            $isLast = $index === $ids->count() - 1;
            $nextIndex = $isLast ? 0 : $index + 1;
            $nextProject = Project::query()->find($ids[$nextIndex]);
        }

        return view('project-show', compact('project', 'nextProject'));
    }
}
