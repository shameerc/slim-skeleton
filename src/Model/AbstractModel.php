<?php

namespace App\Model;

abstract class AbstractModel
{
    public function __construct($db)
    {
        $this->db = $db;
    }
}
