<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MRTOP extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $user;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function build()
    {
        $view = $this->request->RequestStatus === 'Approved'
            ? 'mail.approved'
            : 'mail.forverification';
    
        return $this->view($view)
                    ->with([
                        'request' => $this->request,
                        'user' => $this->user,
                        'qualification_name' => $this->request->qualification->qualification_name,
                    ]);
    }    
}
