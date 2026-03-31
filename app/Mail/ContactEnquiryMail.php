<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
        $replyName = trim(($this->enquiry['first_name'] ?? '').' '.($this->enquiry['last_name'] ?? ''));

        $envelope = new Envelope(
            subject: 'Website enquiry: '.($this->enquiry['enquiry_type'] ?? 'Contact'),
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
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
