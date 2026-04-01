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
        Schema::create('kis_ssr_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('label', 36);
            $table->integer('id_rekomendasi');
            $table->integer('id_tindak_lanjut');
            $table->text('tindak_lanjut')->nullable();
            $table->text('upload_file')->nullable();
            $table->decimal('rincian_keuangan', 20, 2)->default(0);
            $table->decimal('setor', 20, 2)->default(0);
            $table->decimal('rincian_keuangan2', 20, 2)->default(0);
            $table->decimal('setor2', 20, 2)->default(0);
            $table->decimal('rincian_keuangan3', 20, 2)->default(0);
            $table->decimal('setor3', 20, 2)->default(0);
            $table->decimal('rincian_keuangan4', 20, 2)->default(0);
            $table->decimal('setor4', 20, 2)->default(0);
            $table->integer('id_status');
            $table->text('keterangan')->nullable();
            $table->date('tgl_tindak_lanjut');
            $table->dateTime('created_at');
            $table->string('created_by', 255);
            $table->dateTime('edited_at')->nullable();
            $table->string('edited_by', 255)->nullable();
            $table->dateTime('approve_at')->nullable();
            $table->string('approve_by', 255)->nullable();
            $table->text('reject_note')->nullable();
            $table->dateTime('reject_at')->nullable();
            $table->string('reject_by', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_ssr_approvals');
    }
};
