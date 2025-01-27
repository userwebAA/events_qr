<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            // Rendre la colonne user_response nullable
            $table->text('user_response')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->text('user_response')->nullable(false)->change();
        });
    }
};