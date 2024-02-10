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
        Schema::table('transactions', function (Blueprint $table) {
            $table->char('currency', 3)->nullable();
            $table->integer('stripe_net')->nullable();
            $table->integer('stripe_fee')->nullable();
            $table->integer('our_fee')->nullable();
            $table->string('payment_intent');
            $table->integer('amount_net')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'stripe_net',
                'stripe_fee',
                'our_fee',
                'payment_intent',
            ]);
            $table->integer('amount_net')->change();
        });
    }
};
