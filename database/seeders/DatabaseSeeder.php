<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Category;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users=User::factory(20)->create();
        Category::factory(6)->create();
        Animal::factory(30)->create();
        Transfer::factory(10)->create();

        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class
        ]);
        
        foreach($users as $user)
        {
            $user->assignRole('guest');
        }
    }
}
