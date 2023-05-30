<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone;
    public $message;
    public $exc_name;

    /**
     * Create a new message instance.
     *
     * @param  string  $name
     * @param  string  $phone
     * @param  string  $message
     * @return void
     */
    public function __construct($name, $phone, $message, $exc_name)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->message = $message;
        $this->exc_name = $exc_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('rufpow@yandex.ru')->markdown('emails.feedback')
        ->with([
            'name' => $this->name,
            'phone' => $this->phone,
            'message' => $this->message,
            'exc_name' => $this->exc_name
        ]);
    }
}
