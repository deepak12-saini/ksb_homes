<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Models\NewsletterSubscriber;
use App\Models\Project;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'projectsTotal' => Project::query()->count(),
            'projectsFeaturedHome' => Project::query()->where('featured_on_home', true)->count(),
            'newsletterTotal' => NewsletterSubscriber::query()->count(),
            'contactEnquiriesTotal' => ContactEnquiry::query()->count(),
            'recentNewsletterSubscribers' => NewsletterSubscriber::query()
                ->latest()
                ->limit(12)
                ->get(),
            'recentContactEnquiries' => ContactEnquiry::query()
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }
}
