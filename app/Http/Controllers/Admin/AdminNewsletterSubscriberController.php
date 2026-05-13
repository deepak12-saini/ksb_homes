<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\View\View;

class AdminNewsletterSubscriberController extends Controller
{
    public function index(): View
    {
        $subscribers = NewsletterSubscriber::query()
            ->latest()
            ->paginate(50);

        return view('admin.newsletter-subscribers.index', compact('subscribers'));
    }
}
