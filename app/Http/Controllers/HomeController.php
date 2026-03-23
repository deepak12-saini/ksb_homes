<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

        return view('home', [
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
