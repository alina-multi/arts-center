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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_user_id')->index();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->integer('amount_gross');
            $table->smallInteger('type')->index();
            $table->integer('amount_net');
            $table->string('from_email');
            $table->text('message')->nullable();
            $table->json('event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
