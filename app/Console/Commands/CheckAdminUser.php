<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckAdminUser extends Command
{
    protected $signature = 'admin:check {email}';
    protected $description = 'Check if admin user exists and verify password';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} does not exist!");
            return;
        }

        $this->info("User found:");
        $this->table(
            ['Name', 'Email', 'Created At'],
            [[$user->name, $user->email, $user->created_at]]
        );
    }
}
