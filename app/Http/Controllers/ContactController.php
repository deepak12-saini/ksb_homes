<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enquiry_type' => ['required', 'string', 'max:255'],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:50'],
            'email'        => ['required', 'email', 'max:255'],
            'postcode'     => ['required', 'string', 'max:20'],
            'message'      => ['nullable', 'string'],
            'consent'      => ['nullable', 'boolean'],
        ]);

        // Here you could email or persist the enquiry.
        // For now we just acknowledge the submission.

        return back()
            ->withInput()
            ->with('contact_success', 'Thank you for your enquiry. We will be in touch soon.');
    }
}

