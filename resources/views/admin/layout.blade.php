<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') – KSB Luxury Homes</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f172a;
            --ink-soft: #475569;
            --muted: #64748b;
            --line: #e5e8ee;
            --bg: #f4f6f9;
            --card: #ffffff;
            --brand: #c9a962;
            --brand-dark: #a98c48;
            --sidebar: #0b1120;
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --success-bg: #ecfdf5;
            --success-ink: #065f46;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --danger-ink: #991b1b;
            --radius: 14px;
            --radius-sm: 9px;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
            --shadow: 0 2px 8px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 18px 40px -20px rgba(15, 23, 42, 0.28);
            --sidebar-w: 250px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { -webkit-text-size-adjust: 100%; }

        .admin-body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--ink);
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
            font-size: 15px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        /* :where() keeps this reset at zero specificity so component classes always win */
        :where(.admin-body) :where(a) { color: inherit; }

        /* ---------------- Shell ---------------- */
        .admin-shell { display: flex; min-height: 100vh; }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 60;
            width: var(--sidebar-w);
            background: var(--sidebar);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            padding: 1.35rem 0 1rem;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
        }

        .admin-sidebar__brand {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0 1.35rem 1.25rem;
            margin-bottom: 0.9rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .admin-sidebar__logo {
            width: 38px;
            height: 38px;
            flex: none;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: linear-gradient(140deg, var(--brand), var(--brand-dark));
            color: #12161f;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.02em;
        }

        .admin-sidebar__brand-text { min-width: 0; }

        .admin-sidebar__brand-text strong {
            display: block;
            color: #fff;
            font-size: 0.94rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .admin-sidebar__brand-text span {
            display: block;
            font-size: 0.7rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #7c8798;
            margin-top: 2px;
        }

        .admin-sidebar__label {
            padding: 0 1.35rem;
            margin: 0 0 0.5rem;
            font-size: 0.66rem;
            font-weight: 600;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #5b6779;
        }

        .admin-sidebar__nav {
            list-style: none;
            margin: 0;
            padding: 0 0.75rem;
            flex: 1;
            overflow-y: auto;
        }

        .admin-sidebar__nav-item + .admin-sidebar__nav-item { margin-top: 2px; }

        .admin-sidebar__nav-item a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.62rem 0.75rem;
            border-radius: 10px;
            font-size: 0.885rem;
            font-weight: 500;
            color: #b6c0cf;
            text-decoration: none;
            transition: background 0.16s ease, color 0.16s ease;
        }

        .admin-sidebar__nav-item a:hover {
            background: var(--sidebar-hover);
            color: #fff;
            text-decoration: none;
        }

        .admin-sidebar__nav-item a svg {
            width: 18px;
            height: 18px;
            flex: none;
            opacity: 0.85;
        }

        .admin-sidebar__nav-item--active a {
            background: rgba(201, 169, 98, 0.14);
            color: #fff;
            font-weight: 600;
        }

        .admin-sidebar__nav-item--active a::before {
            content: "";
            position: absolute;
            left: -0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            border-radius: 0 3px 3px 0;
            background: var(--brand);
        }

        .admin-sidebar__nav-item--active a svg { opacity: 1; color: var(--brand); }

        .admin-sidebar__footer {
            padding: 0.9rem 1.35rem 0;
            margin-top: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.73rem;
            color: #64748b;
        }

        /* ---------------- Content ---------------- */
        .admin-content {
            flex: 1;
            min-width: 0;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1.75rem;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: saturate(180%) blur(12px);
            -webkit-backdrop-filter: saturate(180%) blur(12px);
            border-bottom: 1px solid var(--line);
        }

        .admin-topbar__left { display: flex; align-items: center; gap: 0.85rem; min-width: 0; }

        .admin-topbar h1 {
            margin: 0;
            font-size: 1.14rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-topbar__actions { display: flex; align-items: center; gap: 0.5rem; }

        .admin-burger {
            display: none;
            width: 38px;
            height: 38px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff;
            color: var(--ink);
            cursor: pointer;
            place-items: center;
        }

        .admin-burger svg { width: 19px; height: 19px; }

        .admin-main { padding: 1.6rem 1.75rem 3rem; }

        /* ---------------- Cards ---------------- */
        .admin-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.4rem 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.25rem;
        }

        .admin-card > h2 {
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .admin-card__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.1rem;
        }

        .admin-card__head h2 { margin: 0; font-size: 1.05rem; font-weight: 600; letter-spacing: -0.01em; }

        .admin-muted { color: var(--muted); font-size: 0.88rem; margin: 0 0 1rem; }

        /* ---------------- Buttons ---------------- */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.56rem 1.05rem;
            background: var(--ink);
            color: #fff;
            border: 1px solid var(--ink);
            border-radius: 10px;
            text-decoration: none;
            font-family: inherit;
            font-size: 0.86rem;
            font-weight: 500;
            line-height: 1.2;
            cursor: pointer;
            white-space: nowrap;
            transition: transform 0.14s ease, background 0.16s ease, border-color 0.16s ease, box-shadow 0.16s ease;
        }

        .admin-btn:hover {
            background: #1e293b;
            border-color: #1e293b;
            color: #fff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .admin-btn:active { transform: translateY(0); }

        .admin-btn:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

        .admin-btn svg { width: 16px; height: 16px; }

        .admin-btn--secondary {
            background: #fff;
            color: var(--ink-soft);
            border-color: var(--line);
        }

        .admin-btn--secondary:hover {
            background: #f8fafc;
            color: var(--ink);
            border-color: #cbd5e1;
        }

        .admin-btn--brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            border-color: var(--brand-dark);
            color: #14181f;
        }

        .admin-btn--brand:hover { filter: brightness(1.05); color: #14181f; }

        .admin-btn--danger { background: var(--danger); border-color: var(--danger); }
        .admin-btn--danger:hover { background: #b91c1c; border-color: #b91c1c; }

        .admin-btn--sm { padding: 0.34rem 0.7rem; font-size: 0.79rem; border-radius: 8px; }

        .admin-btn-group { display: inline-flex; align-items: center; gap: 0.4rem; }

        /* ---------------- Toolbar / search ---------------- */
        .admin-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.1rem;
        }

        .admin-search {
            position: relative;
            flex: 1 1 260px;
            max-width: 380px;
        }

        .admin-search svg {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--muted);
            pointer-events: none;
        }

        .admin-search input {
            width: 100%;
            padding: 0.55rem 0.85rem 0.55rem 2.25rem;
            font-family: inherit;
            font-size: 0.87rem;
            color: var(--ink);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            transition: border-color 0.16s ease, box-shadow 0.16s ease;
        }

        .admin-search input:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(201, 169, 98, 0.16);
        }

        .admin-toolbar select {
            padding: 0.55rem 2rem 0.55rem 0.8rem;
            font-family: inherit;
            font-size: 0.87rem;
            color: var(--ink);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2364748b' d='M1.41 0L6 4.58 10.59 0 12 1.41l-6 6-6-6z'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
            border: 1px solid var(--line);
            border-radius: 10px;
            appearance: none;
            cursor: pointer;
        }

        .admin-toolbar select:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(201, 169, 98, 0.16);
        }

        .admin-toolbar__spacer { flex: 1 1 auto; }

        /* ---------------- Tables ---------------- */
        .admin-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .admin-table th,
        .admin-table td {
            padding: 0.8rem 0.95rem;
            text-align: left;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        .admin-table thead th {
            position: sticky;
            top: 0;
            background: #f8fafc;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            white-space: nowrap;
        }

        .admin-table tbody tr { transition: background 0.14s ease; }
        .admin-table tbody tr:hover { background: #f9fafc; }
        .admin-table tbody tr:last-child td { border-bottom: none; }

        .admin-table a { color: var(--ink); text-decoration: none; }
        .admin-table a:hover { color: var(--brand-dark); text-decoration: underline; }

        .admin-table__actions { text-align: right; white-space: nowrap; }

        .admin-table__id { color: var(--muted); font-variant-numeric: tabular-nums; }

        .admin-table__strong { font-weight: 600; }

        /* Definition-style table (detail pages) */
        .admin-table--detail tbody th {
            width: 230px;
            background: #f8fafc;
            font-weight: 600;
            color: var(--ink-soft);
            font-size: 0.82rem;
        }

        /* ---------------- Badges ---------------- */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.73rem;
            font-weight: 600;
            line-height: 1.5;
            white-space: nowrap;
        }

        .admin-badge--on { background: #ecfdf5; color: #047857; }
        .admin-badge--off { background: #f1f5f9; color: #64748b; }
        .admin-badge--brand { background: rgba(201, 169, 98, 0.16); color: var(--brand-dark); }
        .admin-badge--info { background: #eff6ff; color: #1d4ed8; }

        /* ---------------- Stats ---------------- */
        .admin-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 1rem;
        }

        .admin-stat {
            position: relative;
            padding: 1.15rem 1.25rem;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 13px;
            overflow: hidden;
        }

        .admin-stat::after {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 3px;
            background: linear-gradient(180deg, var(--brand), transparent);
            opacity: 0;
            transition: opacity 0.18s ease;
        }

        a.admin-stat--link {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: transform 0.16s ease, box-shadow 0.16s ease, border-color 0.16s ease;
        }

        a.admin-stat--link:hover {
            transform: translateY(-2px);
            border-color: #d7dde7;
            box-shadow: var(--shadow-lg);
            text-decoration: none;
        }

        a.admin-stat--link:hover::after { opacity: 1; }

        a.admin-stat--link:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

        .admin-stat__icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #f1f5f9;
            color: var(--ink-soft);
            margin-bottom: 0.75rem;
        }

        .admin-stat__icon svg { width: 17px; height: 17px; }

        .admin-stat__value {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.15rem;
            color: var(--ink);
            line-height: 1.1;
            letter-spacing: -0.02em;
            font-variant-numeric: tabular-nums;
        }

        .admin-stat__label { font-size: 0.82rem; color: var(--muted); margin: 0; }

        /* ---------------- Forms ---------------- */
        .admin-form label { display: block; margin-bottom: 0.35rem; font-weight: 500; font-size: 0.86rem; color: var(--ink-soft); }

        .admin-form input[type="text"],
        .admin-form input[type="number"],
        .admin-form input[type="email"],
        .admin-form input[type="url"],
        .admin-form input[type="password"],
        .admin-form textarea,
        .admin-form select {
            width: 100%;
            max-width: 460px;
            padding: 0.6rem 0.8rem;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--ink);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            transition: border-color 0.16s ease, box-shadow 0.16s ease;
        }

        .admin-form input:focus,
        .admin-form textarea:focus,
        .admin-form select:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(201, 169, 98, 0.16);
        }

        .admin-form textarea { min-height: 110px; resize: vertical; line-height: 1.6; }

        .admin-form select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2364748b' d='M1.41 0L6 4.58 10.59 0 12 1.41l-6 6-6-6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.85rem center;
            padding-right: 2.2rem;
            cursor: pointer;
        }

        .admin-form input[type="file"] {
            width: 100%;
            max-width: 460px;
            padding: 0.5rem;
            font-size: 0.85rem;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            cursor: pointer;
        }

        .admin-form input[type="file"]::file-selector-button {
            margin-right: 0.75rem;
            padding: 0.4rem 0.8rem;
            font-family: inherit;
            font-size: 0.82rem;
            color: var(--ink);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            cursor: pointer;
        }

        .admin-form .form-group { margin-bottom: 1.15rem; }

        .admin-form .form-group label input[type="checkbox"] {
            width: 17px;
            height: 17px;
            margin-right: 0.55rem;
            vertical-align: -3px;
            accent-color: var(--brand-dark);
            cursor: pointer;
        }

        /* ---------------- Alerts ---------------- */
        .admin-alert {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            padding: 0.85rem 1rem;
            border-radius: 11px;
            margin-bottom: 1.1rem;
            font-size: 0.88rem;
            border: 1px solid transparent;
        }

        .admin-alert svg { width: 18px; height: 18px; flex: none; margin-top: 1px; }

        .admin-alert--success { background: var(--success-bg); color: var(--success-ink); border-color: #a7f3d0; }
        .admin-alert--error { background: var(--danger-bg); color: var(--danger-ink); border-color: #fecaca; }

        .admin-alert ul { margin: 0; padding-left: 1.1rem; }

        /* ---------------- Empty state ---------------- */
        .admin-empty {
            padding: 2.75rem 1.5rem;
            text-align: center;
            border: 1px dashed #d7dde7;
            border-radius: 12px;
            background: #fbfcfd;
        }

        .admin-empty svg { width: 34px; height: 34px; color: #cbd5e1; margin-bottom: 0.65rem; }

        .admin-empty h3 { margin: 0 0 0.3rem; font-size: 0.98rem; font-weight: 600; }

        .admin-empty p { margin: 0 0 1rem; font-size: 0.87rem; color: var(--muted); }

        /* ---------------- Pagination ---------------- */
        .admin-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.85rem;
            margin-top: 1.1rem;
        }

        .admin-pagination__summary { margin: 0; font-size: 0.83rem; color: var(--muted); }
        .admin-pagination__summary strong { color: var(--ink); font-weight: 600; }

        .admin-pagination__list {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .admin-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            min-width: 36px;
            height: 36px;
            padding: 0 0.65rem;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--ink-soft);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 9px;
            text-decoration: none;
            font-variant-numeric: tabular-nums;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .admin-page-link:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: var(--ink);
            text-decoration: none;
        }

        .admin-page-link svg { width: 15px; height: 15px; }

        .admin-page-link.is-active {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
            font-weight: 600;
        }

        .admin-page-link.is-disabled { opacity: 0.45; pointer-events: none; }

        .admin-page-link.is-dots { border-color: transparent; background: transparent; pointer-events: none; }

        /* ---------------- Page content editor ---------------- */
        .admin-card--page-editor { max-width: 940px; }

        .admin-page-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            padding: 0.32rem;
            background: #eef1f6;
            border-radius: 12px;
            margin-bottom: 1.4rem;
        }

        .admin-pill-tab {
            display: inline-block;
            padding: 0.48rem 1.05rem;
            border-radius: 9px;
            text-decoration: none;
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--ink-soft);
            background: transparent;
            border: 1px solid transparent;
            transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        }

        .admin-pill-tab:hover { background: rgba(255, 255, 255, 0.9); color: var(--ink); text-decoration: none; }

        .admin-pill-tab--active {
            background: #fff;
            color: var(--ink);
            box-shadow: var(--shadow-sm);
        }

        .admin-section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--ink);
            margin: 0 0 1.1rem;
            padding-bottom: 0.55rem;
            border-bottom: 1px solid var(--line);
        }

        .admin-card--page-editor .admin-form input[type="text"],
        .admin-card--page-editor .admin-form input[type="url"],
        .admin-card--page-editor .admin-form textarea,
        .admin-card--page-editor .admin-form select { max-width: min(100%, 42rem); }

        .admin-card--page-editor .admin-form textarea { max-width: min(100%, 52rem); }

        .admin-card--page-editor .admin-form .admin-btn[type="submit"] { margin-top: 0.75rem; }

        .admin-thumb-preview {
            margin-top: 0.55rem;
            padding: 0.5rem;
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: 10px;
            display: inline-block;
        }

        .admin-thumb-preview img { max-height: 74px; vertical-align: middle; border-radius: 6px; }

        .admin-backdrop {
            position: fixed;
            inset: 0;
            z-index: 55;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.22s ease, visibility 0.22s ease;
        }

        /* ---------------- Responsive ---------------- */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 224px; }
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1);
                box-shadow: var(--shadow-lg);
            }

            .admin-body.sidebar-open .admin-sidebar { transform: translateX(0); }
            .admin-body.sidebar-open .admin-backdrop { opacity: 1; visibility: visible; }

            .admin-content { margin-left: 0; }
            .admin-burger { display: grid; }
            .admin-topbar { padding: 0.8rem 1.1rem; }
            .admin-main { padding: 1.2rem 1.1rem 2.5rem; }
            .admin-card { padding: 1.15rem 1.1rem; border-radius: 12px; }
        }

        @media (max-width: 560px) {
            .admin-topbar__actions .admin-btn span { display: none; }
            .admin-topbar__actions .admin-btn { padding: 0.5rem 0.7rem; }
            .admin-search { max-width: none; }
            .admin-pagination { justify-content: center; }
        }

        @media print {
            .admin-sidebar, .admin-topbar, .admin-backdrop { display: none !important; }
            .admin-content { margin-left: 0; }
            .admin-card { box-shadow: none; }
        }
    </style>
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar__brand">
                <span class="admin-sidebar__logo">KSB</span>
                <span class="admin-sidebar__brand-text">
                    <strong>KSB Admin</strong>
                    <span>Luxury Homes</span>
                </span>
            </div>

            <p class="admin-sidebar__label">Menu</p>
            <ul class="admin-sidebar__nav">
                <li class="admin-sidebar__nav-item {{ request()->routeIs('admin.dashboard') ? 'admin-sidebar__nav-item--active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                        Dashboard
                    </a>
                </li>
                <li class="admin-sidebar__nav-item {{ request()->routeIs('admin.projects.*') ? 'admin-sidebar__nav-item--active' : '' }}">
                    <a href="{{ route('admin.projects.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-5h6v5"/><path d="M9 11h.01M15 11h.01"/></svg>
                        Manage Projects
                    </a>
                </li>
                <li class="admin-sidebar__nav-item {{ request()->routeIs('admin.page-content.*') ? 'admin-sidebar__nav-item--active' : '' }}">
                    <a href="{{ route('admin.page-content.home.edit') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="M4 9h16"/><path d="M9 20V9"/></svg>
                        Page Content
                    </a>
                </li>
                <li class="admin-sidebar__nav-item {{ request()->routeIs('admin.contact-enquiries.*') ? 'admin-sidebar__nav-item--active' : '' }}">
                    <a href="{{ route('admin.contact-enquiries.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="m4 7 8 6 8-6"/></svg>
                        Contact leads
                    </a>
                </li>
                <li class="admin-sidebar__nav-item {{ request()->routeIs('admin.newsletter-subscribers.*') ? 'admin-sidebar__nav-item--active' : '' }}">
                    <a href="{{ route('admin.newsletter-subscribers.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg>
                        Newsletter
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar__footer">
                &copy; {{ date('Y') }} KSB Luxury Homes
            </div>
        </aside>

        <div class="admin-backdrop" id="adminBackdrop"></div>

        <div class="admin-content">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button type="button" class="admin-burger" id="adminBurger" aria-label="Open menu" aria-controls="adminSidebar" aria-expanded="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1>@yield('title', 'Admin')</h1>
                </div>
                <div class="admin-topbar__actions">
                    <a href="{{ url('/') }}" target="_blank" rel="noopener" class="admin-btn admin-btn--secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6"/><path d="M10 14 21 3"/></svg>
                        <span>View site</span>
                    </a>
                    <form action="{{ route('admin.logout') }}" method="post" style="display:inline;">
                        @csrf
                        <button type="submit" class="admin-btn admin-btn--secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="admin-main">
                @if (session('success'))
                    <div class="admin-alert admin-alert--success">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.5-5"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="admin-alert admin-alert--error">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7.5v5M12 16h.01"/></svg>
                        <ul>
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            var body = document.body;
            var burger = document.getElementById('adminBurger');
            var backdrop = document.getElementById('adminBackdrop');

            function closeSidebar() {
                body.classList.remove('sidebar-open');
                if (burger) burger.setAttribute('aria-expanded', 'false');
            }

            if (burger) {
                burger.addEventListener('click', function () {
                    var open = body.classList.toggle('sidebar-open');
                    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
                });
            }

            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeSidebar();
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
