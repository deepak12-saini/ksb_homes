<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminContactEnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $perPage = in_array((int) $request->query('per_page'), [15, 25, 50, 100], true)
            ? (int) $request->query('per_page')
            : 15;

        $enquiries = ContactEnquiry::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('full_name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhere('suburb_postcode', 'like', '%'.$search.'%')
                        ->orWhere('project_type', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.contact-enquiries.index', compact('enquiries', 'search', 'perPage'));
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
