<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This is really stupid, but sqlite works only when I split it like this.
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('blog_id', 'user_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->json('body')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->text('text')->nullable()->change();
            $table->string('title')->nullable()->change();
        });
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
