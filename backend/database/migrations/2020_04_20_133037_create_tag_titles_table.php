<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tag_id');
            $table->char('language', 2);
            $table->string('title', 40);
            $table->index(['tag_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_titles');
    }
}
