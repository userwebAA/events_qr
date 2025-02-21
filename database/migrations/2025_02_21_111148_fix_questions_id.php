<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixQuestionsId extends Migration
{
    public function up()
    {
        // Créer une nouvelle séquence
        DB::statement('CREATE SEQUENCE IF NOT EXISTS questions_id_seq');
        
        // Définir la valeur actuelle de la séquence
        $maxId = DB::table('questions')->max('id') ?? 0;
        DB::statement("SELECT setval('questions_id_seq', {$maxId})");
        
        // Modifier la colonne id pour utiliser la séquence
        DB::statement('ALTER TABLE questions ALTER COLUMN id SET DEFAULT nextval(\'questions_id_seq\')');
    }

    public function down()
    {
        DB::statement('ALTER TABLE questions ALTER COLUMN id DROP DEFAULT');
        DB::statement('DROP SEQUENCE IF EXISTS questions_id_seq');
    }
}
