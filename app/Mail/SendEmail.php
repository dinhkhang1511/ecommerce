<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $content;
    public $files;
    
    public function __construct($content, $files)
    {
        $this->content = $content;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('emails.send_email');
        foreach($this->files as $path){
            $email->attach(public_path('/'.$path));
        }
        return $email;
    }
}
