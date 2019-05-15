<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Administrador',
            'role' => User::ADMIN,
            'email' => 'rbenavides@kerohogar.cl',
            'password' => Hash::make('password'),
        ]);
        factory(User::class)->create([
            'name' => 'Conductor',
            'role' => User::DRIVER,
            'email' => 'conductor@kerohogar.cl',
            'password' => Hash::make('password'),
        ]);
    }
}
