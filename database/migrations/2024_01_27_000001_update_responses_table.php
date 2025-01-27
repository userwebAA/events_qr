<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            if (!Schema::hasColumn('responses', 'answers')) {
                $table->jsonb('answers')->nullable();
            }
            if (!Schema::hasColumn('responses', 'feedback')) {
                $table->text('feedback')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn(['answers', 'feedback']);
        });
    }
};
