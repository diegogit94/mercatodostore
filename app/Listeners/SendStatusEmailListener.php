<?php

namespace App\Listeners;

use App\Events\StatusUpdatedEvent;
use App\Mail\StatusUpdateMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Ramsey\Collection\Collection;

class SendStatusEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $update = Collect($event);

        Mail::to($update['order']['request']['buyer']['email'])->send(new StatusUpdateMail($update));
    }
}
