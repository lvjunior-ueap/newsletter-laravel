<?php

namespace App\Http\Controllers;

use App\Jobs\AddSubscriberToSender;
use App\Models\Subscriber;
use App\Mail\ConfirmSubscriptionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
         $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $token = Str::uuid();

        $subscriber = Subscriber::create([
            'email' => $request->email,
            'token' => $token,
            'active' => false,
        ]);

        $url = route('newsletter.confirm', $token);

        Mail::to($subscriber->email)
            ->queue(new ConfirmSubscriptionMail($url));


        // AddSubscriberToSender::dispatch($request->email);


        //API ou WEB
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Inscrição realizada com sucesso!'
            ]);
        }

        return redirect('/newsletter')
            ->with('success', 'Inscrição realizada com sucesso!');

    }


    public function confirm(string $token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();

        if ($subscriber->isConfirmed()) {
            return redirect('/newsletter')
                ->with('success', 'Email já confirmado.');
        }

        $subscriber->update([
            'confirmed_at' => now(),
            'active' => true,
            'token' => null,
        ]);

        AddSubscriberToSender::dispatch($subscriber->email);

        return redirect('/newsletter')
            ->with('success', 'Inscrição confirmada com sucesso!');
    }

}
