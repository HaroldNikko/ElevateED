<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $fullname;
    public string $applicantID; // 🔥 idinagdag na property

    public function __construct(string $fullname, string $applicantID)
    {
        $this->fullname = $fullname;
        $this->applicantID = $applicantID; // 🔥 itakda ang applicantID
    }

    public function build()
    {
        return $this->subject('Your Application Has Been Submitted')
                    ->view('emails.application_submitted')
                    ->with([
                        'fullname' => $this->fullname,
                        'applicantID' => $this->applicantID, // 🔥 ipasa sa template
                    ]);
    }
}
