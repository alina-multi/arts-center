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
        Schema::table('work_titles', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->text('description')->nullable();
            $table->string('alt')->nullable();
            $table->string('colors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_titles', function (Blueprint $table) {
            $table->char('title', 30)->change();
            $table->dropColumn('description');
            $table->dropColumn('alt');
            $table->dropColumn('colors');
        });
    }
};
