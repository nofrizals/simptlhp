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
        Schema::create('kis_instansis', function (Blueprint $table) {
            $table->id('id_instansi');
            $table->char('kode_instansi', 16);
            $table->string('nama_instansi', 255);
            $table->integer('id_tim')->nullable();
            $table->integer('created_by');
            $table->dateTime('created_at');
            $table->integer('edited_by')->nullable();
            $table->dateTime('edited_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_instansis');
    }
};
