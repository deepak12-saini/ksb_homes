<?php

namespace App\Http\Controllers;

use App\Mail\ContactEnquiryMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $validated['consent'] = $request->boolean('consent');

        $to = config('mail.contact_to');
        if (! is_string($to) || $to === '') {
            Log::warning('Contact form: mail.contact_to is not configured.');

            return back()
                ->withInput()
                ->with('contact_error', 'Email is not configured. Please contact us by phone or email.');
        }

        try {
            Mail::to($to)->send(new ContactEnquiryMail($validated));
        } catch (\Throwable $e) {
            Log::error('Contact form email failed', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('contact_error', 'We could not send your message right now. Please email us directly or try again shortly.');
        }

        return back()
            ->with('contact_success', 'Thank you for your enquiry. We will be in touch soon.');
    }
}

