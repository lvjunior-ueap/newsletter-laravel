<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\NewsletterSubscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        Log::info('[Newsletter] Subscribe request', [
            'email' => $data['email'],
        ]);

        // 🔐 Antifraude ATÔMICO
        $lockKey = 'newsletter:subscribe:' . strtolower($data['email']);

        if (! Cache::add($lockKey, true, now()->addMinutes(5))) {
            Log::warning('[Newsletter] Duplicate blocked', [
                'email' => $data['email'],
            ]);

            return response()->json([
                'message' => 'Este e-mail já foi processado recentemente',
            ], 429);
        }

        // 🎯 Ponto único de integração
        event(new NewsletterSubscribed($data['email']));

        Log::info('[Newsletter] Event dispatched', [
            'email' => $data['email'],
        ]);

        return response()->json([
            'message' => 'Inscrição realizada com sucesso',
        ]);
    }
}
