<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNewsletterSubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $perPage = in_array((int) $request->query('per_page'), [15, 25, 50, 100], true)
            ? (int) $request->query('per_page')
            : 25;

        $subscribers = NewsletterSubscriber::query()
            ->when($search !== '', fn ($query) => $query->where('email', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'search', 'perPage'));
    }
}
