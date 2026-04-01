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
        Schema::create('kis_kasus', function (Blueprint $table) {
            $table->increments('id_kasus');
            $table->integer('id_jenis_php')->default(0);
            $table->integer('tahun_pemeriksaan')->default(0);
            $table->string('spt', 255)->nullable();
            $table->date('spt_mulai')->nullable();
            $table->date('spt_selesai')->nullable();
            $table->string('nomor_lhp', 100)->nullable();
            $table->date('tanggal_lhp')->nullable();
            $table->string('kode_unor', 20);
            $table->string('nip_ketua', 20)->nullable();
            $table->enum('selesai', ['0', '1'])->default('0');
            $table->dateTime('created_at');
            $table->string('created_by', 20);
            $table->dateTime('edited_at')->nullable();
            $table->string('edited_by', 20)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_kasus');
    }
};
