<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->text('content');
            $table->json('options');
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->nullable();
            $table->string('selected_option')->nullable();
            $table->string('table_id');
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions')
                  ->whereNotNull('id');
        });

        // Insérer la question de satisfaction avec ID 0
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

        // Insérer les questions normales
        $nextId = 1;
        $questions = [
            [
                'content' => 'Comment avez-vous trouvé la qualité de nos plats ?',
                'options' => json_encode(['Excellent', 'Très bien', 'Bien', 'Peut mieux faire']),
                'order' => 1
            ],
            [
                'content' => 'Le service était-il à la hauteur de vos attentes ?',
                'options' => json_encode(['Parfait', 'Très satisfaisant', 'Satisfaisant', 'À améliorer']),
                'order' => 2
            ],
            [
                'content' => 'Comment jugez-vous l\'ambiance du restaurant ?',
                'options' => json_encode(['Très agréable', 'Agréable', 'Correcte', 'À revoir']),
                'order' => 3
            ],
            [
                'content' => 'Le rapport qualité-prix vous semble-t-il justifié ?',
                'options' => json_encode(['Tout à fait', 'Plutôt oui', 'Moyen', 'Non']),
                'order' => 4
            ]
        ];

        foreach ($questions as $question) {
            DB::table('questions')->insert([
                'id' => $nextId++,
                'content' => $question['content'],
                'options' => $question['options'],
                'order' => $question['order'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('responses');
        Schema::dropIfExists('questions');
    }
};
