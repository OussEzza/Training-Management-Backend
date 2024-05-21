<?php

namespace App\Mail;

// TrainingExpiredMail.php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrainingExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    // Define public properties to hold agent and training information
    public $agent;
    public $training;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agent, $training)
    {
        $this->agent = $agent;
        $this->training = $training;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.training_expired');
    }
}
