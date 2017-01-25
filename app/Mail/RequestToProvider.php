<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Provider;
use App\Request;

class RequestToProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $provider;
    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Provider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Fusion Ride availability request')
            ->replyTo($this->request->email)
            ->view('mail.request');
    }
}
