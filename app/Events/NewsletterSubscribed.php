<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\NewsletterSubscribed;
use Illuminate\Support\Facades\Log;


class NewsletterSubscribed
{
    use Dispatchable, SerializesModels;

    public function __construct(public string $email)
    {
        Log::info('[Newsletter] Event instanciado', [
            'email' => $email,
        ]);
    }



    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        event(new NewsletterSubscribed($data['email']));

        return response()->json([
            'message' => 'Inscrição realizada com sucesso',
        ]);
    }
}
