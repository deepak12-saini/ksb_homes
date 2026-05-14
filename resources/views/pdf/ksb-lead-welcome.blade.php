<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>KSB Homes – welcome sheet</title>
    <style>
        @page { margin: 42px 40px 48px 40px; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5pt;
            color: #1a1a1a;
            line-height: 1.5;
            margin: 0;
        }
        .band {
            background: #0a0a0a;
            color: #fafafa;
            padding: 18px 22px;
            margin: -42px -40px 22px -40px;
        }
        .brand { font-size: 22pt; font-weight: 700; letter-spacing: 0.06em; margin: 0; }
        .brand-sub { font-size: 9pt; letter-spacing: 0.28em; text-transform: uppercase; margin: 6px 0 0 0; opacity: 0.92; }
        .tagline { font-size: 10pt; margin: 14px 0 0 0; font-weight: 600; color: #c9c9c9; }
        h2 {
            font-size: 10.5pt;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin: 18px 0 8px 0;
            border-bottom: 1px solid #d4d4d4;
            padding-bottom: 4px;
        }
        p { margin: 0 0 10px 0; }
        ul { margin: 0 0 12px 18px; padding: 0; }
        li { margin-bottom: 4px; }
        .muted { color: #525252; font-size: 9.5pt; }
        .footer {
            margin-top: 22px;
            padding-top: 12px;
            border-top: 1px solid #e5e5e5;
            font-size: 9pt;
            color: #525252;
        }
        .steps-table { width: 100%; border-collapse: collapse; margin: 8px 0 0 0; }
        .steps-table td { vertical-align: top; padding: 6px 10px 6px 0; font-size: 10pt; }
        .step-num {
            width: 22px;
            font-weight: 700;
            color: #0a0a0a;
        }
    </style>
</head>
<body>
    <div class="band">
        <p class="brand">KSB</p>
        <p class="brand-sub">Homes</p>
        <p class="tagline">Design + construct · Sydney North Shore</p>
    </div>

    <p><strong>About KSB Homes</strong></p>
    <p>
        We are a Sydney North Shore studio focused on high-quality residential outcomes: bespoke new homes,
        considered renovations, and select small-lot developments. Design, approvals thinking, and construction
        sit under one roof so your project stays coherent from first sketch to handover.
    </p>

    <h2>How we work with you</h2>
    <table class="steps-table" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="step-num">1</td>
            <td><strong>Discovery</strong> — site, brief, budget, and timing aligned so we propose a realistic path.</td>
        </tr>
        <tr>
            <td class="step-num">2</td>
            <td><strong>Concept &amp; design</strong> — plans, materials, and detail developed with you and your consultants.</td>
        </tr>
        <tr>
            <td class="step-num">3</td>
            <td><strong>Approvals &amp; documentation</strong> — drawings and specifications prepared for consent and tender clarity.</td>
        </tr>
        <tr>
            <td class="step-num">4</td>
            <td><strong>Build</strong> — delivery on site with clear communication and rigorous quality control.</td>
        </tr>
    </table>

    <h2>What to expect after a website enquiry</h2>
    <p>
        When a lead comes in from the website, our team reviews scope, suburb, and timing, then reaches out to
        confirm next steps — usually a short call before any on-site or workshop time is booked.
    </p>

    <h2>Visit us online</h2>
    <p class="muted">
        Latest work, process, and contact options: <strong>{{ $siteUrl !== '' ? $siteUrl : 'your website URL (set APP_URL)' }}</strong>
    </p>

    <div class="footer">
        KSB Homes · Reference sheet for internal use with website leads · {{ $year }}
    </div>
</body>
</html>
