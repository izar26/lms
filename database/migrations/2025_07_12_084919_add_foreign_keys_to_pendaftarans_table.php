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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->foreign(['kursus_id'])->references(['id'])->on('kursus')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign('pendaftarans_kursus_id_foreign');
            $table->dropForeign('pendaftarans_user_id_foreign');
        });
    }
};
