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
        // Supprimer la question de satisfaction globale
        DB::table('questions')->where('id', 0)->delete();

        // Supprimer les réponses associées
        DB::table('responses')->where('question_id', 0)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurer la question de satisfaction globale
        DB::table('questions')->insert([
            'id' => 0,
            'content' => 'Satisfaction globale',
            'options' => json_encode([
                'Très satisfait',
                'Satisfait',
                'Peu satisfait',
                'Pas satisfait'
            ]),
            'order' => 9999,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
};
