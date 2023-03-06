<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    protected $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function getUsers()
    {
        return User::GetAllUsers()->get();
    }
    public function deleteUser($user_id)
    {
        User::where('id',$user_id)->delete();
    }
    public function assignAdminRole($user_id)
    {
        User::where('id',$user_id)->first()->assignRole('admin')->removeRole('guest');
    }
    public function assignGuestRole($user_id)
    {
        User::where('id',$user_id)->first()->assignRole('guest')->removeRole('admin');
    }
}
