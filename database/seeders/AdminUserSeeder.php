<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Events Five Admin',
            'email' => 'contact@events-five.com',
            'password' => Hash::make('Eventsfive31100'),
        ]);
    }
}
