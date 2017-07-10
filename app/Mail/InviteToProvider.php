<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Provider;
use App\Request;

class InviteToProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $provider;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Fusion Ride service activation')
            ->view('mail.invite');
    }
}
