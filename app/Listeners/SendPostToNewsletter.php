<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Services\BrevoService;

class SendPostToNewsletter
{
    public function __construct(
        protected BrevoService $brevo
    ) {}

    public function handle(PostPublished $event): void
    {
        $post = $event->post;

        \Log::info('Listener SendPostToNewsletter executado', [
            'post_id' => $event->post->id,
        ]);

        // TESTE: por enquanto envia só para um email
        $this->brevo->sendTestEmail(
            config('services.brevo.test_email'),
            $post
        );


        //debugando...

        $response = $this->brevo->sendPostEmail(
            config('services.brevo.test_email'),
            $event->post
        );
        
        \Log::info('DEPOIS de chamar Brevo', [
            'status' => $response?->status(),
            'body' => $response?->body(),
        ]);
    }
}
