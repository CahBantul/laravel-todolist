<?php 

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users = [
        "nozami" => "password",
    ];
    function login(string $user, string $password): bool
    {
        if(!isset($this->users[$user])) return false;

        $correstPassword = $this->users[$user];
        return $password == $correstPassword;
    }
}
