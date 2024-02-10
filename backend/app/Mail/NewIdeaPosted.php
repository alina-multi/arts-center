<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIdeaPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $idea;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.admin.newIdea')->subject('New feedback: ' . $this->idea->title)->from($this->idea->user->email, $this->idea->user->name);
    }
}
