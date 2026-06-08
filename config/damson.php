<?php

return [

    /*
    | Set DAMSON_PUBLIC_PREFIX=public on cPanel when assets live under /public/images/...
    | Leave empty to auto-detect from APP_URL (non-localhost → public).
    */
    'public_prefix' => env('DAMSON_PUBLIC_PREFIX'),

    'contact' => [
        'email' => env('DAMSON_CONTACT_EMAIL', 'hello@damsonmushroom.com'),
        'phone' => env('DAMSON_PHONE', '+250 785 171 213'),
        'address' => env('DAMSON_ADDRESS', 'DAMSON Mushroom Farm Ltd — Innovation Campus, Agricultural District'),
        'whatsapp_url' => env('DAMSON_WHATSAPP_URL', 'https://wa.me/250785171213'),
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
        'whatsapp' => env('DAMSON_WHATSAPP_URL', 'https://wa.me/250785171213'),
    ],

    'stats' => [
        'years_experience' => (int) env('DAMSON_STAT_YEARS', 15),
        'farmers_supported' => (int) env('DAMSON_STAT_FARMERS', 1200),
        'products_delivered' => (int) env('DAMSON_STAT_PRODUCTS', 50000),
        'farmers_trained' => (int) env('DAMSON_STAT_TRAINED', 850),
        'spawn_produced' => (int) env('DAMSON_STAT_SPAWN', 250000),
        'products_sold' => (int) env('DAMSON_STAT_SOLD', 75000),
        'yield_improved_pct' => (int) env('DAMSON_STAT_YIELD', 40),
        'training_sessions' => (int) env('DAMSON_STAT_SESSIONS', 320),
        'districts_reached' => (int) env('DAMSON_STAT_DISTRICTS', 18),
    ],

];
