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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kursus_id')->index('testimonis_kursus_id_foreign');
            $table->string('nama_peserta');
            $table->string('pekerjaan');
            $table->text('testimoni');
            $table->string('path_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
