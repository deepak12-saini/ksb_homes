<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_key',
        'field_key',
        'value',
    ];

    public static function getPageValues(string $pageKey, array $defaults = []): array
    {
        $stored = static::query()
            ->where('page_key', $pageKey)
            ->pluck('value', 'field_key')
            ->toArray();

        return array_merge($defaults, $stored);
    }

    public static function upsertPageValues(string $pageKey, array $values): void
    {
        foreach ($values as $fieldKey => $value) {
            static::query()->updateOrCreate(
                [
                    'page_key' => $pageKey,
                    'field_key' => $fieldKey,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }

    /** Default field values for /our-story when nothing is stored yet. */
    public static function ourStoryDefaults(): array
    {
        return [
            'seo_title' => 'Our Story – KSB homes Design + Construct',
            'seo_description' => 'Learn about KSB homes – award-winning design, development, and construction.',
            'hero_label' => 'About',
            'hero_title' => 'Visionary design and construction excellence',
            'hero_image' => null,
            'vision_heading' => 'Vision',
            'vision_paragraph_1' => 'KSB homes is an award-winning design, development, and construction company specialising in luxury residential projects.',
            'vision_paragraph_2' => 'Our goal is to create exceptional projects that set new benchmarks for luxury living.',
            'vision_image' => null,
            'founders_heading' => 'Founders',
            'founders_paragraph_1' => 'KSB Homes is a dedicated construction and home building company focused on delivering quality residential projects.',
            'founders_image' => null,
            'services_heading' => 'Services',
            'services_intro' => 'Architecture, development, and construction—delivered with a single vision from concept to completion.',
            'services_architecture_label' => 'Architecture',
            'services_architecture_text' => 'Concept design, documentation, and coordination tailored to luxury residential outcomes.',
            'services_development_label' => 'Development',
            'services_development_text' => 'Residential and multi-residential development—from site strategy through approvals and delivery.',
            'services_construction_label' => 'Construction',
            'services_construction_text' => 'On-site delivery, quality control, and program management to complete your project to a high standard.',
        ];
    }

    /** Default field values for /contact when nothing is stored yet. */
    public static function contactDefaults(): array
    {
        return [
            'seo_title' => 'Contact – KSB homes Design + Construct',
            'seo_description' => 'Enquire about luxury homes, knockdown rebuilds, and development projects with KSB homes.',
            'hero_image' => null,
            'hero_image_alt' => 'Luxury residential architecture',
            'address_text' => 'Wahroonga Sydney NSW',
            'phone_display' => '0421670636',
            'phone_tel' => '+61421670636',
            'instagram_url' => 'https://www.instagram.com/ksbhomes/',
            'instagram_display' => '@ksbhomes',
            'section_label' => 'Contact',
            'page_heading' => 'Enquire Now',
            'form_headline' => 'Luxury home & development projects from $1M+',
            'form_intro' => 'Tell us about your project. We’ll respond to serious enquiries promptly.',
        ];
    }
}
