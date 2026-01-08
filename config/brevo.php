<?php

return [
    'api_key' => env('BREVO_API_KEY'),

    'lists' => [
        'newsletter' => env('BREVO_NEWSLETTER_LIST_ID'),
    ],
];