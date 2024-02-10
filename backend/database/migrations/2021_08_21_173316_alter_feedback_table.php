<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('title');
            $table->string('type');
            $table->string('language',2);
            $table->string('category')->default('')->change();
            $table->index(['type','category']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('type');
            $table->dropColumn('language');
            $table->dropIndex(['type','category']);
            $table->dropIndex('user_id');
        });
    }
}
