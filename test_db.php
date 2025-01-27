<?php
$host = '127.0.0.1';
$port = '5432';
$dbname = 'qrcode_quiz';
$user = 'postgres';
$password = '1234'; // Utilisez le même mot de passe que dans votre .env

try {
    $dbh = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    echo "Connexion réussie à PostgreSQL\n";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}
