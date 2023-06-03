<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mail extends Mailable
{
    use Queueable, SerializesModels;
    private string $sub;
    private string $message;
    public array $data;
    public string $viewName;

    public function __construct($subject, $message, $viewName) {
        $this->sub = $subject;
        $this->message = $message;
        $this->data = [ 'subject' => $subject, 'message' => $message];
        $this->viewName = $viewName;
    }

    public function build() {
        return $this->view($this->viewName)->with('data', $this->data)
            ->subject($this->sub);
    }
}
