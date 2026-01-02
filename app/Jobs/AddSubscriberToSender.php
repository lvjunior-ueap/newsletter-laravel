<?php

namespace App\Jobs;

use App\Services\SenderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class AddSubscriberToSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle(SenderService $sender)
    {
        $sender->addSubscriber($this->email);
    }
}
