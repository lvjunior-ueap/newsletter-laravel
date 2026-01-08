<?php

namespace App\Listeners;

use App\Events\NewsletterSubscribed;
use App\Services\BrevoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendNewsletterContactToBrevo implements ShouldQueue
{
    public function handle(NewsletterSubscribed $event): void
    {
        Log::info('[Newsletter] Listener iniciado', [
            'email' => $event->email,
        ]);

        try {
            app(\App\Services\BrevoService::class)->createOrUpdateContact(
                email: $event->email,
                attributes: [
                    'ORIGEM' => 'INTRANET',
                ],
                listIds: [(int) config('brevo.lists.newsletter')]
            );

            Log::info('[Newsletter] Enviado para Brevo com sucesso', [
                'email' => $event->email,
            ]);

        } catch (Throwable $e) {
            Log::error('[Newsletter] Erro ao enviar para Brevo', [
                'email' => $event->email,
                'error' => $e->getMessage(),
            ]);

            throw $e; // importante para queue, se estiver usando
        }
    }
}
