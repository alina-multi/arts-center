<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_id');
            $table->char('language', 2);
            $table->string('title');
            $table->json('about');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['blog_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_translations');
    }
}
