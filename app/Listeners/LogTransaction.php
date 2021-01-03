<?php

namespace App\Listeners;

use App\Events\Transaction;
use App\Log;

class LogTransaction
{

    /**
     * @param Transaction $event
     */
    public function handle(Transaction $event)
    {
        $log = new Log();
        $log->insert($event->log());
    }
}
