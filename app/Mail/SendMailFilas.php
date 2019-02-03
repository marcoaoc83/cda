<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFilas extends Mailable
{
    use Queueable, SerializesModels;
    public $to;
    public $titulo;
    public $html;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titulo,$html)
    {

        $this->titulo   = $titulo;
        $this->html     = $html;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cdae@cdae.tecnologia.ws')
            ->view('admin.email.template')
            ->subject($this->titulo)

            ->with([
                'html' => $this->html,
            ]);
    }
}
