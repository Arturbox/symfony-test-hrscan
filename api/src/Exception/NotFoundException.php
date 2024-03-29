<?php

namespace App\Exception;


class NotFoundException extends \RuntimeException
{

    public function __construct(string $table, array|int $id)
    {
        parent::__construct(sprintf("%s id %s not found", $table, is_array($id) ? implode(',', $id) : (string)$id));
    }

}