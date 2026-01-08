<?php

namespace App\Http\Controllers;

use App\Jobs\AddSubscriberToSender;
use App\Models\Subscriber;
use App\Mail\ConfirmSubscriptionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
//adicionado
use App\Mail\AllPostsNewsletter;
use App\Models\Post;

use App\Services\BrevoService;

//logs
use Illuminate\Support\Facades\Log;
use App\Events\NewsletterSubscribed;

//ajuste para melhorar
use Illuminate\Support\Facades\Cache;

class NewsletterController extends Controller
{

    // extra


    public function sendAllPostsTest()
    {
        $posts = Post::where('published', true)
            ->orderBy('created_at')
            ->get();

        Mail::to('teste@mailpit.local')
            ->send(new AllPostsNewsletter($posts));

        return response()->json([
            'message' => 'Newsletter enviada para o Mailpit',
            'posts' => $posts->count(),
        ]);
    }



    //para funcionamento com api do brevo
    public function subscribe(Request $request)
    {
        Log::info('[Newsletter] Controller chamado', [
            'email' => $request->email,
        ]);

        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        //adicionada key como proteção...

        $key = 'newsletter:' . md5($data['email']);

        if (Cache::has($key)) {
            return response()->json([
                'message' => 'Este e-mail já foi processado recentemente',
            ], 200);
        }

        Cache::put($key, true, now()->addMinutes(5));

        // código continua normalmente...

        event(new NewsletterSubscribed($data['email']));

        Log::info('[Newsletter] Event disparado', [
            'email' => $data['email'],
        ]);

        return response()->json([
            'message' => 'Inscrição realizada com sucesso',
        ]);
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




    //METODO DE TESTE BREVO
    public function brevoTest(BrevoService $brevo)
    {
        $email = config('services.brevo.test_email');

        $contact = $brevo->createContact($email, [
            2 // ID da lista no Brevo (ajuste)
        ]);

        $mail = $brevo->sendTestEmail($email);

        return response()->json([
            'contact' => $contact->json(),
            'email' => $mail->json(),
        ]);
    }


    //adicionar subscriber
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        event(new ContatoInscritoNewsletter($data['email']));

        return back()->with('success', 'Inscrição realizada com sucesso!');
    }

}
