<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $guestRole = Role::create(['name' => 'guest']);

        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'transfers']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'edit-animal']);


        $adminRole->syncPermissions([
            'users',
            'transfers',
            'edit-categories',
            'edit-animal'
        ]);
    }

}
