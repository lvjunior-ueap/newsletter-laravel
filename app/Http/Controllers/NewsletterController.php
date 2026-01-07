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



    ///função que funciona
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
