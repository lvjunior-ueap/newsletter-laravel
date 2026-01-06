<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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
}
