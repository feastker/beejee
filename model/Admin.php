<?php

class Admin extends Model
{

    protected $table = 'admin';

    function auth($login, $password)
    {

        $admin = $this->get(false, [
            'login' => $login,
            'password' => $password
        ]);

        if (empty($admin)) {
            return false;
        }

        return true;
    }


}