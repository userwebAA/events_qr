<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Supprimer la question de feedback
        DB::table('questions')->where('id', -1)->delete();

        // Modifier la contrainte de clé étrangère pour permettre l'ID -1
        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions')
                  ->where('id', '>', -2); // Permet l'ID -1 pour les commentaires
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recréer la question de feedback
        DB::table('questions')->insert([
            'id' => -1,
            'content' => 'Commentaire',
            'options' => json_encode(['Commentaire']),
            'order' => 10000,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Rétablir la contrainte de clé étrangère originale
        Schema::table('responses', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions');
        });
    }
};
