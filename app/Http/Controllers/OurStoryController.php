<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class OurStoryController extends Controller
{
    public function __invoke(): View
    {
        $spotlight = Project::query()
            ->where('featured_on_home', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(2)
            ->get();

        return view('our-story', [
            'spotlightProjects' => $spotlight,
        ]);
    }
}
