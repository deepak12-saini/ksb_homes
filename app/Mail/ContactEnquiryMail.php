<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ContactEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $enquiry
     */
    public function __construct(public array $enquiry)
    {
    }

    public function envelope(): Envelope
    {
        $replyEmail = $this->enquiry['email'] ?? null;
        $replyName = trim((string) ($this->enquiry['full_name'] ?? ''));

        $looking = $this->enquiry['looking_to_do'] ?? [];
        $lookingStr = is_array($looking) ? implode(', ', $looking) : (string) $looking;
        $subject = 'Website lead – KSB Homes';
        if ($lookingStr !== '') {
            $subject .= ': '.mb_substr($lookingStr, 0, 72).(mb_strlen($lookingStr) > 72 ? '…' : '');
        }

        $envelope = new Envelope(
            subject: $subject,
        );

        if (is_string($replyEmail) && $replyEmail !== '') {
            $envelope->replyTo([new Address($replyEmail, $replyName !== '' ? $replyName : $replyEmail)]);
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-enquiry',
            with: [
                'static_lead_pdf_attached' => $this->staticLeadPdfWillAttach(),
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // TODO: When the client confirms the project guide PDF should go out with lead emails,
        // uncomment the block below and restore staticLeadPdfWillAttach() to match.
        // $brochure = $this->resolveLeadBrochureAttachment();
        // if ($brochure !== null) {
        //     $attachments[] = $brochure;
        // }

        $diskPath = $this->enquiry['attachment_storage_path'] ?? null;
        if (is_string($diskPath) && $diskPath !== '') {
            $name = $this->enquiry['attachment_original_name'] ?? basename($diskPath);
            if (Storage::disk('public')->exists($diskPath)) {
                $attachments[] = Attachment::fromStorageDisk('public', $diskPath)->as((string) $name);
            } elseif (Storage::disk('local')->exists($diskPath)) {
                $attachments[] = Attachment::fromStorageDisk('local', $diskPath)->as((string) $name);
            }
        }

        return $attachments;
    }

    public function staticLeadPdfWillAttach(): bool
    {
        // When client confirms project guide PDF: uncomment brochure block in attachments()
        // and replace this body with:
        //   if ($this->resolveConfiguredLeadPdfAttachment() !== null) { return true; }
        //   return (bool) config('mail.lead_pdf_generate_default', true);
        return false;
    }

    protected function resolveLeadBrochureAttachment(): ?Attachment
    {
        return $this->resolveConfiguredLeadPdfAttachment()
            ?? $this->resolveGeneratedLeadPdfAttachment();
    }

    protected function resolveConfiguredLeadPdfAttachment(): ?Attachment
    {
        $configured = config('mail.lead_pdf_path');
        if (! is_string($configured) || trim($configured) === '') {
            return null;
        }

        $configured = trim($configured);
        $displayName = (string) config('mail.lead_pdf_name', 'KSB Homes - information.pdf');

        if (is_file($configured)) {
            return Attachment::fromPath($configured)->as($displayName);
        }

        $normalized = ltrim(str_replace('\\', '/', $configured), '/');
        if (Storage::disk('local')->exists($normalized)) {
            return Attachment::fromStorageDisk('local', $normalized)->as($displayName);
        }

        $publicPath = public_path($normalized);
        if (is_file($publicPath)) {
            return Attachment::fromPath($publicPath)->as($displayName);
        }

        return null;
    }

    protected function resolveGeneratedLeadPdfAttachment(): ?Attachment
    {
        if (! (bool) config('mail.lead_pdf_generate_default', true)) {
            return null;
        }

        $displayName = (string) config('mail.lead_pdf_name', 'KSB Homes - information.pdf');
        $generator = app(\App\Services\LeadWelcomePdfGenerator::class);

        return Attachment::fromData(
            fn () => $generator->binary(),
            $displayName
        )->withMime('application/pdf');
    }
}
