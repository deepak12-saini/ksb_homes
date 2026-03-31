<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact enquiry</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #1a1a1a;">
    <h1 style="font-size: 1.125rem; margin: 0 0 1rem;">New contact enquiry</h1>
    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse;">
        <tr><td><strong>Enquiry type</strong></td><td>{{ $enquiry['enquiry_type'] ?? '—' }}</td></tr>
        <tr><td><strong>Name</strong></td><td>{{ $enquiry['first_name'] ?? '' }} {{ $enquiry['last_name'] ?? '' }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $enquiry['phone'] ?? '—' }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $enquiry['email'] ?? '—' }}</td></tr>
        <tr><td><strong>Postcode</strong></td><td>{{ $enquiry['postcode'] ?? '—' }}</td></tr>
        <tr><td valign="top"><strong>Message</strong></td><td>{{ $enquiry['message'] ?? '—' }}</td></tr>
        <tr><td><strong>Marketing consent</strong></td><td>{{ ! empty($enquiry['consent']) ? 'Yes' : 'No' }}</td></tr>
    </table>
</body>
</html>
