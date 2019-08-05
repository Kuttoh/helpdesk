<?php

namespace App\Repositories;

use App\User;

class UserRepository

{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }
}
