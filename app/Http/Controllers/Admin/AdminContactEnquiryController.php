<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminContactEnquiryController extends Controller
{
    public function index(): View
    {
        $enquiries = ContactEnquiry::query()
            ->latest()
            ->paginate(25);

        return view('admin.contact-enquiries.index', compact('enquiries'));
    }

    public function show(ContactEnquiry $contact_enquiry): View
    {
        return view('admin.contact-enquiries.show', [
            'enquiry' => $contact_enquiry,
        ]);
    }

    public function downloadAttachment(ContactEnquiry $contact_enquiry)
    {
        $path = $contact_enquiry->attachment_storage_path;
        if (! is_string($path) || $path === '') {
            abort(404);
        }

        $name = $contact_enquiry->attachment_original_name ?: basename($path);

        if (Storage::disk('public')->exists($path)) {
            return response()->download(Storage::disk('public')->path($path), $name);
        }

        if (Storage::disk('local')->exists($path)) {
            return response()->download(Storage::disk('local')->path($path), $name);
        }

        abort(404);
    }
}
