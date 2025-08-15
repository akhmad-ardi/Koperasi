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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sekolah');
            $table->string('no_anggota', 20);
            $table->string('nama', 50);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir', 50);
            $table->date('tgl_lahir');
            $table->string('pekerjaan', 50);
            $table->text('alamat');
            $table->char('no_telepon', 13);
            $table->char('nik', 16);
            $table->char('nip', 18);
            $table->string('foto_diri', 50);
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->date('tgl_gabung');

            $table->foreign('id_sekolah')->references('id')->on('sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
