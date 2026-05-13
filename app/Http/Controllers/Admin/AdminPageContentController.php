<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageContentController extends Controller
{
    public function editHome(): View
    {
        return view('admin.page-content.home', [
            'content' => PageContent::getPageValues('home', $this->homeDefaults()),
        ]);
    }

    public function updateHome(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_title_line_1' => ['required', 'string', 'max:255'],
            'hero_title_line_2' => ['required', 'string', 'max:255'],
            'hero_tagline' => ['required', 'string', 'max:500'],
            'about_paragraph_1' => ['required', 'string'],
            'about_paragraph_2' => ['required', 'string'],
            'about_paragraph_3' => ['required', 'string'],
            'about_paragraph_4' => ['required', 'string'],
            'about_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $contentToSave = [
            'hero_title_line_1' => $validated['hero_title_line_1'],
            'hero_title_line_2' => $validated['hero_title_line_2'],
            'hero_tagline' => $validated['hero_tagline'],
            'about_paragraph_1' => $validated['about_paragraph_1'],
            'about_paragraph_2' => $validated['about_paragraph_2'],
            'about_paragraph_3' => $validated['about_paragraph_3'],
            'about_paragraph_4' => $validated['about_paragraph_4'],
        ];

        if ($request->hasFile('about_image')) {
            $contentToSave['about_image'] = $request->file('about_image')->store('page-content', 'public');
        }

        PageContent::upsertPageValues('home', $contentToSave);

        return redirect()->route('admin.page-content.home.edit')->with('success', 'Home page content updated.');
    }

    public function editOurStory(): View
    {
        return view('admin.page-content.our-story', [
            'content' => PageContent::getPageValues('our_story', PageContent::ourStoryDefaults()),
        ]);
    }

    public function updateOurStory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_title' => ['required', 'string', 'max:255'],
            'seo_description' => ['required', 'string', 'max:500'],
            'hero_label' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:500'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
            'vision_heading' => ['required', 'string', 'max:255'],
            'vision_paragraph_1' => ['required', 'string'],
            'vision_paragraph_2' => ['required', 'string'],
            'vision_image' => ['nullable', 'image', 'max:4096'],
            'founders_heading' => ['required', 'string', 'max:255'],
            'founders_paragraph_1' => ['required', 'string'],
            'founders_image' => ['nullable', 'image', 'max:4096'],
            'services_heading' => ['required', 'string', 'max:255'],
            'services_intro' => ['required', 'string'],
            'services_architecture_label' => ['required', 'string', 'max:255'],
            'services_architecture_text' => ['required', 'string'],
            'services_development_label' => ['required', 'string', 'max:255'],
            'services_development_text' => ['required', 'string'],
            'services_construction_label' => ['required', 'string', 'max:255'],
            'services_construction_text' => ['required', 'string'],
        ]);

        $contentToSave = [
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
            'hero_label' => $validated['hero_label'],
            'hero_title' => $validated['hero_title'],
            'vision_heading' => $validated['vision_heading'],
            'vision_paragraph_1' => $validated['vision_paragraph_1'],
            'vision_paragraph_2' => $validated['vision_paragraph_2'],
            'founders_heading' => $validated['founders_heading'],
            'founders_paragraph_1' => $validated['founders_paragraph_1'],
            'services_heading' => $validated['services_heading'],
            'services_intro' => $validated['services_intro'],
            'services_architecture_label' => $validated['services_architecture_label'],
            'services_architecture_text' => $validated['services_architecture_text'],
            'services_development_label' => $validated['services_development_label'],
            'services_development_text' => $validated['services_development_text'],
            'services_construction_label' => $validated['services_construction_label'],
            'services_construction_text' => $validated['services_construction_text'],
        ];

        if ($request->hasFile('hero_image')) {
            $contentToSave['hero_image'] = $request->file('hero_image')->store('page-content', 'public');
        }
        if ($request->hasFile('vision_image')) {
            $contentToSave['vision_image'] = $request->file('vision_image')->store('page-content', 'public');
        }
        if ($request->hasFile('founders_image')) {
            $contentToSave['founders_image'] = $request->file('founders_image')->store('page-content', 'public');
        }

        PageContent::upsertPageValues('our_story', $contentToSave);

        return redirect()->route('admin.page-content.our-story.edit')->with('success', 'Our Story page content updated.');
    }

    public function editContact(): View
    {
        return view('admin.page-content.contact', [
            'content' => PageContent::getPageValues('contact', PageContent::contactDefaults()),
        ]);
    }

    public function updateContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_title' => ['required', 'string', 'max:255'],
            'seo_description' => ['required', 'string', 'max:500'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
            'hero_image_alt' => ['required', 'string', 'max:255'],
            'address_text' => ['required', 'string', 'max:500'],
            'phone_display' => ['required', 'string', 'max:80'],
            'phone_tel' => ['required', 'string', 'max:80', 'regex:/^\+?[0-9\-\s()]+$/'],
            'instagram_url' => ['required', 'url', 'max:500'],
            'instagram_display' => ['required', 'string', 'max:120'],
            'section_label' => ['required', 'string', 'max:120'],
            'page_heading' => ['required', 'string', 'max:255'],
            'form_headline' => ['required', 'string', 'max:500'],
            'form_intro' => ['required', 'string', 'max:2000'],
        ]);

        $contentToSave = [
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
            'hero_image_alt' => $validated['hero_image_alt'],
            'address_text' => $validated['address_text'],
            'phone_display' => $validated['phone_display'],
            'phone_tel' => preg_replace('/\s+/', '', $validated['phone_tel']),
            'instagram_url' => $validated['instagram_url'],
            'instagram_display' => $validated['instagram_display'],
            'section_label' => $validated['section_label'],
            'page_heading' => $validated['page_heading'],
            'form_headline' => $validated['form_headline'],
            'form_intro' => $validated['form_intro'],
        ];

        if ($request->hasFile('hero_image')) {
            $contentToSave['hero_image'] = $request->file('hero_image')->store('page-content', 'public');
        }

        PageContent::upsertPageValues('contact', $contentToSave);

        return redirect()->route('admin.page-content.contact.edit')->with('success', 'Contact page content updated.');
    }

    private function homeDefaults(): array
    {
        return [
            'hero_title_line_1' => 'BUILDING',
            'hero_title_line_2' => 'DREAM HOMES',
            'hero_tagline' => 'KSB Luxury Homes — Barker and Knox alumni building luxury homes on the North Shore.',
            'about_paragraph_1' => "KSB Luxury Homes is a high-end design, development and construction company specialising in luxury residential projects across the blue chip suburbs of Sydney's North Shore.",
            'about_paragraph_2' => "Founded and led by alumni of Barker College and Knox Grammar, two of the North Shore's most prestigious institutions, we're not just building in this area—we grew up here. We know these streets, these neighbourhoods, and the families who call them home. That local connection runs through everything we do.",
            'about_paragraph_3' => "Our goal is to create exceptional homes that set new benchmarks for luxury living. We take the premium residential sector to new heights by delivering projects underpinned by visionary design, superior craftsmanship, and an unwavering commitment to excellence.",
            'about_paragraph_4' => 'For us, building on the North Shore isn’t just business it’s personal.',
            'about_image' => null,
        ];
    }
}
