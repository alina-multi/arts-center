<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('work_id');
            $table->char('language', 2);
            $table->string('type');
            $table->integer('order');
            $table->json('data');
            $table->timestamps();
            $table->index(['work_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_blocks');
    }
}
