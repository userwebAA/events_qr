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
        // Insérer la question de feedback
        DB::table('questions')->insert([
            'id' => -1,
            'content' => 'Commentaire',
            'options' => json_encode(['Commentaire']),
            'order' => 10000, // Un ordre encore plus élevé que la satisfaction
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer la question de feedback
        DB::table('questions')->where('id', -1)->delete();
    }
};
