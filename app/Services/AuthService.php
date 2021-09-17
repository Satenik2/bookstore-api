<?php

namespace App\Services;

use App\Models\User;

class AuthService
{

    private function __construct() {}

    public static function register($data): User
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $plainPassword = $data['password'];
        $user->password = app('hash')->make($plainPassword);
        $user->save();
        return $user;
    }

}
