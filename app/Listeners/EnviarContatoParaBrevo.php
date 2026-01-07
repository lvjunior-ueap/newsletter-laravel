<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarContatoParaBrevo implements ShouldQueue
{
    public function handle(ContatoInscritoNewsletter $event)
    {
        app(BrevoService::class)->createOrUpdateContact(
            email: $event->email,
            listIds: [3] // ID da lista Newsletter
        );
    }
}
