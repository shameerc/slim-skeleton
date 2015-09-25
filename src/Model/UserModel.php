<?php

namespace App\Model;

class UserModel extends AbstractModel
{
    public function getUsers()
    {
        $result = $this->db->fetchAll('SELECT * FROM users');

        return $result;
    }
}
