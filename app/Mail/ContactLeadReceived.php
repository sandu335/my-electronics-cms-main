<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactLeadReceived extends Mailable
{
    use Queueable, SerializesModels;

    public Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function build()
    {
        return $this->subject('Mesaj nou de contact: ' . $this->lead->name)
            ->view('emails.lead')
            ->with(['lead' => $this->lead]);
    }
}
