<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SenderService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.sender.net/v2';

    public function __construct()
    {
        $this->apiKey = config('services.sender.api_key');
    }

    /**
     * Envia email de novo post publicado
     */
    public function sendNewPost(Post $post, string $toEmail): bool
    {
        $response = Http::withToken($this->apiKey)
            ->post($this->baseUrl . '/email', [
                'from' => [
                    'email' => config('mail.from.address'),
                    'name'  => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $toEmail,
                    ]
                ],
                'subject' => 'Novo post publicado: ' . $post->title,
                'html' => view('emails.api.new-post', [
                    'post' => $post
                ])->render(),
            ]);

       if ($response->failed()) {
            Log::error('Sender API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        }

        Log::info('Sender API response', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        return true;
    }
}
