<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use App\Models\Post; 

class BrevoService
{
    protected string $baseUrl = 'https://api.brevo.com/v3';

    protected function headers(): array
    {
        return [
            'api-key' => config('services.brevo.key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];
    }

    public function createContact(string $email, array $listIds = [])
    {
        return Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/contacts", [
                'email' => $email,
                'listIds' => $listIds,
                'updateEnabled' => true,
            ]);
    }

    //função nova...
    public function createOrUpdateContact(
        string $email,
        array $attributes = [],
        array $listIds = []
    ): void {
        Http::withHeaders([
            'api-key' => config('services.brevo.api_key'),
        ])->post('https://api.brevo.com/v3/contacts', [
            'email' => $email,
            'attributes' => $attributes,
            'listIds' => $listIds,
            'updateEnabled' => true,
        ])->throw();
    }

    public function sendTestEmail(string $to)
    {
        return Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/smtp/email", [
                'sender' => [
                    'name' => 'LV Junior',
                    'email' => 'newsletter@lvjunior.xyz',
                ],
                'to' => [
                    ['email' => $to],
                ],
                'subject' => 'Teste Laravel + Brevo API',
                'htmlContent' => '<p>Email enviado com <b>Laravel + Brevo</b> 🚀</p>',
            ]);
    }



    //POST EMAIL

    public function sendPostEmail(string $to, Post $post)
    {
        $url = url("/post/{$post->slug}");

        return Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/smtp/email", [
                'sender' => [
                    'name' => 'LV Junior',
                    'email' => 'newsletter@lvjunior.xyz',
                ],
                'to' => [
                    ['email' => $to],
                ],
                'subject' => "Nova notícia: {$post->title}",
                'htmlContent' => "
                    <h2>{$post->title}</h2>
                    <p>{$post->excerpt}</p>
                    <p>
                        <a href='{$url}'>Ler notícia</a>
                    </p>
                ",
            ]);
    }
    
}
