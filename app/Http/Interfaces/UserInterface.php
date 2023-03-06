<?php

namespace App\Http\Interfaces;

interface UserInterface {

    public function getUsers();
    public function deleteUser($user_id);
    public function assignAdminRole($user_id);
    public function assignGuestRole($user_id);
}
