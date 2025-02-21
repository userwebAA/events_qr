<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Commande Artisan pour créer un utilisateur administrateur dans l'application.
 * Cette commande permet de générer rapidement un compte admin avec les droits nécessaires.
 *
 * @example
 * php artisan admin:create admin@example.com mot_de_passe123
 */
class CreateAdminUser extends Command
{
    /**
     * La signature de la commande avec ses arguments.
     * {email} : L'adresse email de l'administrateur
     * {password} : Le mot de passe pour le compte
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {password}';

    /**
     * Description détaillée de la commande.
     *
     * @var string
     */
    protected $description = 'Créer un nouvel utilisateur administrateur avec l\'email et le mot de passe spécifiés';

    /**
     * Exécute la commande de création d'administrateur.
     * 
     * @return void
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Création de l'utilisateur admin dans la base de données
        $user = User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin user created successfully with email: {$email}");
    }
}
