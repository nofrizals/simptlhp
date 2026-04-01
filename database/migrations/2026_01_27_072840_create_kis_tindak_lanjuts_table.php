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
        Schema::create('kis_tindak_lanjuts', function (Blueprint $table) {
            $table->id('id_tindak_lanjut');
            $table->integer('id_rekomendasi');
            $table->text('tindak_lanjut')->nullable();
            $table->text('upload_file1')->nullable();
            $table->text('upload_file2')->nullable();
            $table->text('upload_file3')->nullable();
            $table->text('upload_file4')->nullable();
            $table->text('upload_file5')->nullable();
            $table->decimal('rincian_keuangan', 20, 2)->default(0.00);
            $table->decimal('setor', 20, 2)->default(0.00);
            $table->decimal('rincian_keuangan2', 20, 2)->default(0.00);
            $table->decimal('setor2', 20, 2)->default(0.00);
            $table->decimal('rincian_keuangan3', 20, 2)->default(0.00);
            $table->decimal('setor3', 20, 2)->default(0.00);
            $table->decimal('rincian_keuangan4', 20, 2)->default(0.00);
            $table->decimal('setor4', 20, 2)->default(0.00);
            $table->integer('id_status')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tgl_tindak_lanjut');
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
        Schema::dropIfExists('kis_tindak_lanjuts');
    }
};
