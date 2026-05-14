<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class LeadWelcomePdfGenerator
{
    public function binary(): string
    {
        return Pdf::loadView('pdf.ksb-lead-welcome', [
            'year' => (int) date('Y'),
            'siteUrl' => rtrim((string) config('app.url'), '/'),
        ])
            ->setPaper('a4', 'portrait')
            ->output();
    }
}
