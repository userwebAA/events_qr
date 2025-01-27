<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->text('user_response')->after('id');
            $table->dropColumn('answers');
            $table->dropColumn('feedback');
        });
    }

    public function down()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn('user_response');
            $table->jsonb('answers')->nullable();
            $table->text('feedback')->nullable();
        });
    }
};
