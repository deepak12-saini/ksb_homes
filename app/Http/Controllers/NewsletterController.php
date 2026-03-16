<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Store a new newsletter subscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        $email = $validated['email'];

        if (NewsletterSubscriber::where('email', $email)->exists()) {
            return back()->with('newsletter_info', 'This email is already subscribed to our newsletter.');
        }

        NewsletterSubscriber::create(['email' => $email]);

        return back()->with('newsletter_success', 'Thank you! You have been subscribed to our newsletter.');
    }
}
