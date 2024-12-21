<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        return $this->subject('Donation Request Approved')
        ->view('emails.donation_approved')
        ->with([
            'message' => 'Hi Thanks for raising donation request. Your request has been approved by our team, someone will contact you soon for next process. Thanks for choosing Blood Donation System. Please feel free to share your feedback and queries.'
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
