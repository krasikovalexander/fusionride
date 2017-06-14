<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Track;

class Quoted extends Mailable
{
    use Queueable, SerializesModels;

    public $track;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Fusion Ride new quote')
            ->view('mail.quoted');
    }
}
