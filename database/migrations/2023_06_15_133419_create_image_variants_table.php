<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->index();
            $table->char('extension', 4);
            $table->unsignedSmallInteger('width');
            $table->unsignedSmallInteger('height');
            $table->unsignedInteger('size');
            $table->boolean('original')->default(false);
            $table->timestamps();
            $table->index('extension', 'width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_variants');
    }
};
