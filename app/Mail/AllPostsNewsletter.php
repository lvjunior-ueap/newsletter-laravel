<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AllPostsNewsletter extends Mailable
{
    use SerializesModels;

    public function __construct(
        public $posts
    ) {}

    public function build()
    {
        return $this
            ->subject('Todas as notícias do site')
            ->view('emails.newsletter-all-posts');
    }
}