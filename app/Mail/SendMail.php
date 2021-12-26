<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)

    {

        // dd($details);
        $this->details = $details;
        
    }

  

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->subject('Verifikasi Account SIMPUS')->markdown('auth.verif',$this->details)) {
            return redirect('login');
        }
        // dd($this->details);
        // return $this->subject('Verifikasi Account SIMPUS')

        // ->view('auth.verif',$this->details);
       
    }
}
