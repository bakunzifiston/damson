<?php

return [

    'contact' => [
        'email' => env('DAMSON_CONTACT_EMAIL', 'hello@damsonmushroom.com'),
        'phone' => env('DAMSON_PHONE', '+1 (555) 010-2030'),
        'address' => env('DAMSON_ADDRESS', 'DAMSON Mushroom Farm Ltd — Innovation Campus, Agricultural District'),
    ],

    'social' => [
        'facebook' => env('DAMSON_SOCIAL_FACEBOOK', 'https://facebook.com'),
        'instagram' => env('DAMSON_SOCIAL_INSTAGRAM', 'https://instagram.com'),
        'linkedin' => env('DAMSON_SOCIAL_LINKEDIN', 'https://linkedin.com'),
        'youtube' => env('DAMSON_SOCIAL_YOUTUBE', 'https://youtube.com'),
    ],

    'live_chat' => [
        'enabled' => env('DAMSON_LIVE_CHAT_ENABLED', false),
        'hours' => 'Mon–Sat, 8:00–18:00 (local time)',
        'whatsapp' => env('DAMSON_WHATSAPP_URL'),
    ],

];
