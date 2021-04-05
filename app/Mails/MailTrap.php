<?php

namespace App\Mails;

use App\Models\ToDo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTrap extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->task = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): MailTrap
    {
        return $this->view('mails.taskMail');
    }
}
