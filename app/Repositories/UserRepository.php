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

    public function update($input, $id)
    {
        $user = $this->getUserById($id);

        $user->update($input);
    }

    public function postMakeEngineer($input, $id)
    {
        $user = $this->getUserById($id);

        $user->update([
            'role_id' => 2
        ]);

        return redirect('/users');
    }
}
