<?php

/**
 * Single source of truth for lead form options (avoids Blade vs controller typos / dash mismatches).
 * Use ASCII hyphens only so values match across environments.
 */
return [
    'looking_options' => [
        'Build a New Home',
        'Knockdown Rebuild',
        'Renovation / Extension',
        'Duplex / Dual Occupancy',
        'Luxury Custom Home',
        'Development Project (Multi-dwelling)',
        'Joint Venture Opportunity',
        'Land Owner - Looking to Develop',
        'Just Exploring / Early Stage',
    ],

    /** Checkbox values that trigger Development / JV follow-up fields */
    'dev_triggers' => [
        'Development Project (Multi-dwelling)',
        'Joint Venture Opportunity',
        'Land Owner - Looking to Develop',
    ],

    'project_types' => [
        'Single Dwelling',
        'Duplex',
        'Multi-dwelling / Development',
        'Custom Luxury Home',
    ],

    'budgets' => [
        '$500k - $1M',
        '$1M - $2M',
        '$2M - $3M',
        '$3M - $5M',
        '$5M+',
    ],

    'timelines' => [
        'Ready to start immediately',
        'Within 3 months',
        '3-6 months',
        '6-12 months',
        'Just planning',
    ],

    'project_stages' => [
        'Just researching',
        'Working with architect/designer',
        'Plans ready',
        'DA / CDC approved',
        'Ready to build',
    ],

    'project_goals' => [
        'Owner occupier',
        'Investment / rental',
        'Build to sell',
        'Development for profit',
    ],

    'looking_for_partner' => [
        'Builder only',
        'Builder + Developer',
        'Joint venture partner',
    ],

    'hear_about' => [
        'Instagram',
        'Google',
        'Referral',
        'Real estate agent',
        'Other',
    ],
];
