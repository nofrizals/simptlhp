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
        Schema::create('kis_pembayarans', function (Blueprint $table) {
            $table->id(); // id (auto increment)
            $table->integer('id_tindak_lanjut'); // int, not null
            $table->string('jenis', 20); // varchar(20)
            $table->string('file_bukti', 255); // varchar(255)
            $table->bigInteger('nominal')->nullable(); // bigint, null
            $table->text('keterangan')->nullable(); // text, null
            $table->integer('created_by')->nullable(); // int, null
            $table->timestamp('created_at')->nullable(); // timestamp, null
            $table->integer('deleted_by')->nullable(); // int, null
            $table->timestamp('deleted_at')->nullable(); // timestamp, null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_pembayarans');
    }
};
