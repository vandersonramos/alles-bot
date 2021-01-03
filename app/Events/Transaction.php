<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class Transaction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $log;

    /**
     * LogTransaction constructor.
     * @param array $log
     */
    public function __construct(array $log)
    {
        $this->log = $log;
    }

    /**
     * @return array
     */
    public function log(): array
    {
        return $this->log;
    }
}
