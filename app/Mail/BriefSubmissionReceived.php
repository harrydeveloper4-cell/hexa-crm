<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BriefSubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    private $pdfPath;

    public function __construct(array $data, $pdfPath)
    {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($this->data['formRequest']->form_title . ' brief submitted')
            ->view('mails.brief_submission_received')
            ->attach($this->pdfPath, [
                'as' => \Illuminate\Support\Str::slug($this->data['formRequest']->form_title) . '-submission.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
