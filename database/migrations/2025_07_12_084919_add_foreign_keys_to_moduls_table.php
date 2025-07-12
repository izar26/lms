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
        Schema::table('moduls', function (Blueprint $table) {
            $table->foreign(['kursus_id'])->references(['id'])->on('kursus')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moduls', function (Blueprint $table) {
            $table->dropForeign('moduls_kursus_id_foreign');
        });
    }
};
