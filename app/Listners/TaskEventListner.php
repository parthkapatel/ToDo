<?php

namespace App\Listners;

use App\Events\TaskEvent;
use App\Mails\MailTrap;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TaskEventListner implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param $data
     */
    public function handle($data)
    {
        Mail::to("parthpatel7851@gmail.com")->send(new MailTrap($data->data));
    }

}
