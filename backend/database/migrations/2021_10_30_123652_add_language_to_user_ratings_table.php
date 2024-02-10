<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageToUserRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_ratings', function (Blueprint $table) {
            $table->char('language',2);
            $table->dropUnique(['ratable_type', 'ratable_id', 'user_id']);
            $table->unique(['ratable_type', 'ratable_id', 'user_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_ratings', function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
}
