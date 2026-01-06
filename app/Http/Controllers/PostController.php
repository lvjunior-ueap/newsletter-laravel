<?php

namespace App\Http\Controllers;
//mais
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AllPostsNewsletter;

//novo
use App\Mail\NewPostPublishedMail;

//senderservice
use App\Services\SenderService;


use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('published', true)
            ->orderByDesc('created_at')
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }



    //adicionando para etapa2

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request, SenderService $sender)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(5),
            'excerpt' => Str::limit(strip_tags($data['content']), 150),
            'content' => $data['content'],
            'published' => true,
        ]);

        // 🚀 envio via API Sender
        $sender->sendNewPost($post, 'guiapq@gmail.com');

        return redirect('/')
            ->with('success', 'Post criado e email enviado!');
    }
    
}
