<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kursus', function (Blueprint $table) {
            $table->foreign('instruktur_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kursus', function (Blueprint $table) {
            $table->dropForeign(['instruktur_id']);
        });
    }
};
