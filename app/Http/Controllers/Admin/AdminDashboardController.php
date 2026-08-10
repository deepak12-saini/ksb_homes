<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Models\NewsletterSubscriber;
use App\Models\Project;
use App\Support\AdminAuth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $user = AdminAuth::user();
        $isAdmin = $user?->isAdmin() ?? false;

        $data = [
            'isAdmin' => $isAdmin,
            'projectsTotal' => Project::query()->count(),
            'projectsFeaturedHome' => Project::query()->where('featured_on_home', true)->count(),
        ];

        if ($isAdmin) {
            $data['newsletterTotal'] = NewsletterSubscriber::query()->count();
            $data['contactEnquiriesTotal'] = ContactEnquiry::query()->count();
            $data['recentNewsletterSubscribers'] = NewsletterSubscriber::query()
                ->latest()
                ->limit(12)
                ->get();
            $data['recentContactEnquiries'] = ContactEnquiry::query()
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('admin.dashboard', $data);
    }
}
