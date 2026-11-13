<?php

declare(strict_types=1);

return [

    'client_id' => env('GOOGLE_GMAIL_CLIENT_ID'),
    'client_secret' => env('GOOGLE_GMAIL_CLIENT_SECRET'),
    'refresh_token' => env('GOOGLE_GMAIL_REFRESH_TOKEN'),
    'sender_email' => env('GOOGLE_GMAIL_SENDER_EMAIL', env('MAIL_FROM_ADDRESS', 'no-reply@msva.test')),
    'daily_quota' => (int) env('GOOGLE_GMAIL_DAILY_QUOTA', 500),
    'fake' => (bool) env('GMAIL_FAKE', false),

    'token_url' => env('GOOGLE_GMAIL_TOKEN_URL', 'https://oauth2.googleapis.com/token'),
    'api_url' => env('GOOGLE_GMAIL_API_URL', 'https://gmail.googleapis.com/gmail/v1'),
    'timeout' => (int) env('GOOGLE_GMAIL_TIMEOUT', 15),

];
