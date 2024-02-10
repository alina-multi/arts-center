<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowPerLanguageToWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->boolean('show_en')->default(0)->index();
            $table->boolean('show_ru')->default(0)->index();
            $table->boolean('show_uk')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('show_en');
            $table->dropColumn('show_ru');
            $table->dropColumn('show_uk');
        });
    }
}
