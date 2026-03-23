<?php

namespace App\Http\Controllers;

use App\Models\CustomProjectEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KsbSelectController extends Controller
{
    public function create(): View
    {
        return view('ksb-select.step1');
    }

    public function storeStep1(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:50'],
            'postcode'   => ['nullable', 'string', 'max:20'],
        ]);

        session(['ksb_select_step1' => $request->only(['first_name', 'last_name', 'email', 'phone', 'postcode'])]);

        return redirect()->route('ksb-select.step2');
    }

    public function step2()
    {
        if (! session()->has('ksb_select_step1')) {
            return redirect()->route('ksb-select.index');
        }

        return view('ksb-select.step2');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! session()->has('ksb_select_step1')) {
            return redirect()->route('ksb-select.index');
        }

        $request->validate([
            'project_description' => ['required', 'string', 'max:10000'],
        ]);

        $step1 = session('ksb_select_step1');

        CustomProjectEnquiry::create([
            'first_name'           => $step1['first_name'],
            'last_name'            => $step1['last_name'],
            'email'                => $step1['email'],
            'phone'                => $step1['phone'],
            'postcode'             => $step1['postcode'] ?? null,
            'project_description'  => $request->input('project_description'),
        ]);

        session()->forget('ksb_select_step1');

        return redirect()
            ->route('ksb-select.index')
            ->with('ksb_select_success', 'Thank you. We have received your custom project enquiry and will be in touch soon.');
    }
}
