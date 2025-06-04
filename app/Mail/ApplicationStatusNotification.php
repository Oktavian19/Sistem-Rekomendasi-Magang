<?php

// app/Mail/ApplicationStatusNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $lamaran;
    public $status;

    public function __construct($lamaran, $status)
    {
        $this->lamaran = $lamaran;
        $this->status = $status;
    }

    public function build()
    {
        return $this->view('emails.application_status')
                    ->subject('Status Lamaran Magang');
    }

}