<?php

namespace App\Exceptions;

use Exception;

class TicketSoldOutException extends Exception
{
    protected $message = 'Билеты на выбранное место распроданы';

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
