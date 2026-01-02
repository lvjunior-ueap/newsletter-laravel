<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SenderService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.sender.base_url');
        $this->apiKey  = config('services.sender.api_key');
    }

    protected function request()
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ]);
    }

    public function addSubscriber(string $email)
    {
        return $this->request()->post("{$this->baseUrl}/subscribers", [
            'email' => $email,
        ]);
    }

    public function removeSubscriber(string $email)
    {
        return $this->request()->delete("{$this->baseUrl}/subscribers/{$email}");
    }
}
