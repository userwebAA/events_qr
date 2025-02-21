<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('response_history', function (Blueprint $table) {
            $table->id();
            $table->string('table_id');  // Changé en string car c'est le type dans la table responses
            $table->unsignedBigInteger('question_id')->nullable();
            $table->string('selected_option')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('set null');
            $table->index(['table_id', 'created_at']);
        });

        // Copier les données existantes avec conversion de type
        DB::statement('INSERT INTO response_history (table_id, question_id, selected_option, feedback, created_at, updated_at)
            SELECT CAST(table_id AS VARCHAR), question_id, selected_option, feedback, created_at, updated_at
            FROM responses');
    }

    public function down()
    {
        Schema::dropIfExists('response_history');
    }
};
