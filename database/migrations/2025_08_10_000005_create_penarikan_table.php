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
        Schema::create('penarikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anggota');
            $table->date('tgl_penarikan');
            $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela']);
            $table->integer('jumlah_penarikan');
            $table->string('keterangan', 50);

            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};
