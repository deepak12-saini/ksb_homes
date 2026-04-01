<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KSB website lead</title>
</head>
<body style="font-family: system-ui, -apple-system, sans-serif; line-height: 1.5; color: #1a1a1a; max-width: 640px;">
    <h1 style="font-size: 1.125rem; margin: 0 0 1rem; font-weight: 600;">New website lead – KSB Homes</h1>

    @php
        $looking = $enquiry['looking_to_do'] ?? [];
        $lookingLabel = is_array($looking) ? implode(', ', $looking) : (string) $looking;
    @endphp

    <p style="margin: 0 0 1rem; font-size: 0.875rem; color: #444;"><strong>What they’re looking to do:</strong><br>{{ $lookingLabel !== '' ? $lookingLabel : '—' }}</p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; font-size: 0.875rem;">
        <tr><td><strong>Full name</strong></td><td>{{ $enquiry['full_name'] ?? '—' }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $enquiry['phone'] ?? '—' }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $enquiry['email'] ?? '—' }}</td></tr>
        <tr><td><strong>Suburb / postcode</strong></td><td>{{ $enquiry['suburb_postcode'] ?? '—' }}</td></tr>
        <tr><td><strong>Own land?</strong></td><td>{{ ($enquiry['land_owner'] ?? '') === 'yes' ? 'Yes' : (($enquiry['land_owner'] ?? '') === 'no' ? 'No' : '—') }}</td></tr>
        <tr><td><strong>Site address</strong></td><td>{{ $enquiry['site_address'] ?? '—' }}</td></tr>
        <tr><td><strong>Project type</strong></td><td>{{ $enquiry['project_type'] ?? '—' }}</td></tr>
        <tr><td><strong>Budget</strong></td><td>{{ $enquiry['budget'] ?? '—' }}</td></tr>
        <tr><td><strong>Timeline</strong></td><td>{{ $enquiry['timeline'] ?? '—' }}</td></tr>
        <tr><td><strong>Project stage</strong></td><td>{{ $enquiry['project_stage'] ?? '—' }}</td></tr>
        <tr><td><strong>Project goal</strong></td><td>{{ $enquiry['project_goal'] ?? '—' }}</td></tr>
        @if(!empty($enquiry['estimated_project_value']) || !empty($enquiry['number_of_dwellings']) || !empty($enquiry['looking_for_partner']))
        <tr><td colspan="2" style="padding-top:12px;"><strong>Development / JV details</strong></td></tr>
        <tr><td><strong>Est. project value</strong></td><td>{{ $enquiry['estimated_project_value'] ?? '—' }}</td></tr>
        <tr><td><strong>No. of dwellings</strong></td><td>{{ $enquiry['number_of_dwellings'] ?? '—' }}</td></tr>
        <tr><td><strong>Looking for</strong></td><td>{{ $enquiry['looking_for_partner'] ?? '—' }}</td></tr>
        @endif
        <tr><td><strong>How they heard about us</strong></td><td>{{ $enquiry['hear_about_us'] ?? '—' }}{{ ($enquiry['hear_about_us'] ?? '') === 'Other' && !empty($enquiry['hear_about_other']) ? ' – '.$enquiry['hear_about_other'] : '' }}</td></tr>
        <tr><td valign="top"><strong>Message</strong></td><td>{{ $enquiry['message'] ?? '—' }}</td></tr>
        <tr><td><strong>Serious enquiry consent</strong></td><td>{{ ! empty($enquiry['consent']) ? 'Yes' : 'No' }}</td></tr>
    </table>
    @if(!empty($static_lead_pdf_attached))
        <p style="margin-top: 1rem; font-size: 0.8125rem; color: #444;"><strong>Attachment:</strong> A KSB Homes PDF is attached to this email for download.</p>
    @endif
    @if(!empty($enquiry['attachment_original_name']))
        <p style="margin-top: 0.5rem; font-size: 0.8125rem; color: #444;"><strong>Enquirer upload:</strong> {{ $enquiry['attachment_original_name'] }}</p>
    @endif
</body>
</html>
