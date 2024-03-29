<?php

namespace App\Exception;


class ServiceException extends \RuntimeException
{

    public function __construct(string $message)
    {
        parent::__construct(sprintf("Error %s", $message));
    }

}