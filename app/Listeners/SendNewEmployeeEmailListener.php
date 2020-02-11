<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\NewEmployeeEmail;

class SendNewEmployeeEmailListener implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        sleep(5);

        Mail::to($event->data_email['email'])->send(new NewEmployeeEmail($event->data_email['template']));
    }
}
