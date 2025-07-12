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
        Schema::create('kursus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->unsignedBigInteger('instruktur_id');
            $table->text('deskripsi');
            $table->string('path_gambar')->nullable();
            $table->boolean('apakah_eksklusif')->default(false);
            $table->unsignedBigInteger('harga')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursus');
    }
};
