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
        Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pinjaman'); // pinjaman yang kena denda
            $table->date('tgl_denda'); // tanggal denda dikenakan
            $table->integer('jumlah_denda'); // nominal denda
            $table->date('tgl_bayar')->nullable(); // kapan dibayar
            $table->enum('status', ['lunas', 'belum lunas'])->default('belum lunas');

            $table->foreign('id_pinjaman')->references('id')->on('pinjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
