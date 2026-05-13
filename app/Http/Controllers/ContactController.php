<?php

namespace App\Http\Controllers;

use App\Mail\ContactEnquiryMail;
use App\Models\ContactEnquiry;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact', [
            'contactContent' => PageContent::getPageValues('contact', PageContent::contactDefaults()),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $lf = config('lead_form');

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'suburb_postcode' => ['required', 'string', 'max:120'],
            'looking_to_do' => ['required', 'array', 'min:1'],
            'looking_to_do.*' => ['string', Rule::in($lf['looking_options'])],
            'land_owner' => ['required', Rule::in(['yes', 'no'])],
            'site_address' => ['nullable', 'string', 'max:500'],
            'project_type' => ['required', 'string', Rule::in($lf['project_types'])],
            'budget' => ['required', 'string', Rule::in($lf['budgets'])],
            'timeline' => ['required', 'string', Rule::in($lf['timelines'])],
            'project_stage' => ['required', 'string', Rule::in($lf['project_stages'])],
            'project_goal' => ['required', 'string', Rule::in($lf['project_goals'])],
            'estimated_project_value' => [
                Rule::requiredIf(fn () => self::needsDevSection($request)),
                'nullable',
                'string',
                'max:255',
            ],
            'number_of_dwellings' => [
                Rule::requiredIf(fn () => self::needsDevSection($request)),
                'nullable',
                'string',
                'max:50',
            ],
            'looking_for_partner' => [
                Rule::requiredIf(fn () => self::needsDevSection($request)),
                'nullable',
                'string',
                Rule::in($lf['looking_for_partner']),
            ],
            'hear_about_us' => ['required', 'string', Rule::in($lf['hear_about'])],
            'hear_about_other' => [
                Rule::requiredIf(fn () => $request->input('hear_about_us') === 'Other'),
                'nullable',
                'string',
                'max:255',
            ],
            'message' => ['nullable', 'string', 'max:10000'],
            'plans' => ['nullable', 'file', 'max:15360'],
            'consent' => ['required', 'accepted'],
        ]);

        $validated['consent'] = true;

        $attachmentStoragePath = null;
        $attachmentOriginal = null;
        if ($request->hasFile('plans')) {
            $file = $request->file('plans');
            $attachmentOriginal = $file->getClientOriginalName();
            $attachmentStoragePath = $file->store('contact-enquiry-plans', 'public');
        }

        $enquiry = ContactEnquiry::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'suburb_postcode' => $validated['suburb_postcode'],
            'looking_to_do' => $validated['looking_to_do'],
            'land_owner' => $validated['land_owner'],
            'site_address' => $validated['site_address'] ?? null,
            'project_type' => $validated['project_type'],
            'budget' => $validated['budget'],
            'timeline' => $validated['timeline'],
            'project_stage' => $validated['project_stage'],
            'project_goal' => $validated['project_goal'],
            'estimated_project_value' => $validated['estimated_project_value'] ?? null,
            'number_of_dwellings' => $validated['number_of_dwellings'] ?? null,
            'looking_for_partner' => $validated['looking_for_partner'] ?? null,
            'hear_about_us' => $validated['hear_about_us'],
            'hear_about_other' => $validated['hear_about_other'] ?? null,
            'message' => $validated['message'] ?? null,
            'consent' => true,
            'attachment_storage_path' => $attachmentStoragePath,
            'attachment_original_name' => $attachmentOriginal,
        ]);

        $payload = array_merge($validated, [
            'attachment_storage_path' => $attachmentStoragePath,
            'attachment_original_name' => $attachmentOriginal,
            'id' => $enquiry->id,
        ]);

        $to = config('mail.contact_to');
        if (! is_string($to) || $to === '') {
            Log::warning('Contact form: mail.contact_to is not configured.', ['contact_enquiry_id' => $enquiry->id]);

            return back()
                ->withInput()
                ->with('contact_error', 'Email is not configured. Your enquiry was saved; please contact us by phone or email.');
        }

        try {
            $mailable = new ContactEnquiryMail($payload);
            Mail::to($to)->send($mailable);
            Log::info('Contact form email sent', [
                'to' => $to,
                'contact_enquiry_id' => $enquiry->id,
                'static_pdf' => $mailable->staticLeadPdfWillAttach(),
                'upload_path' => $attachmentStoragePath,
            ]);
        } catch (\Throwable $e) {
            Log::error('Contact form email failed', [
                'message' => $e->getMessage(),
                'contact_enquiry_id' => $enquiry->id,
            ]);

            return back()
                ->withInput()
                ->with('contact_error', 'We could not send email right now, but your enquiry was saved. Please email us directly or try again shortly.');
        }

        return back()
            ->with('contact_success', 'Thank you for your enquiry. We will be in touch soon.');
    }

    private static function needsDevSection(Request $request): bool
    {
        $triggers = config('lead_form.dev_triggers', []);
        $looking = $request->input('looking_to_do', []);
        if (! is_array($looking)) {
            $looking = [];
        }
        if (count(array_intersect($looking, $triggers)) > 0) {
            return true;
        }
        if ($request->input('project_type') === 'Multi-dwelling / Development') {
            return true;
        }
        if ($request->input('project_goal') === 'Development for profit') {
            return true;
        }

        return false;
    }
}
