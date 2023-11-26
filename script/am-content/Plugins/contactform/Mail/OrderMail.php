<?php

namespace Amcoders\Plugin\contactform\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('plugin::emails.order')->with('data',$this->data)->attach($this->data["file"], [
            'as' => 'invoice.pdf',
            'mime' => 'application/pdf',
        ])
        ;;
    }
}
