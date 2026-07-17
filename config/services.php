<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
        'calendar_id' => env('GOOGLE_CALENDAR_ID', 'primary'),
        'maps_key' => env('GOOGLE_MAPS_KEY'),
        'analytics_id' => env('GOOGLE_ANALYTICS_ID'),
        'search_console_verification' => env('GOOGLE_SEARCH_CONSOLE_VERIFICATION'),
        'timezone' => env('GOOGLE_CALENDAR_TIMEZONE', 'Europe/Riga'),
        'onsite_location' => env('GOOGLE_ONSITE_LOCATION', 'Lairin birojs'),
        'business_hours' => [
            'start' => env('GOOGLE_BUSINESS_HOURS_START', '09:00'),
            'end' => env('GOOGLE_BUSINESS_HOURS_END', '17:00'),
        ],
        'slot_interval_minutes' => (int) env('GOOGLE_SLOT_INTERVAL_MINUTES', 30),
        'admin_email' => env('GOOGLE_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),
    ],

];
