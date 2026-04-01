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
        Schema::create('kis_tim_anggota', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY, AUTO_INCREMENT
            $table->integer('id_tim');
            $table->integer('id_user');
            // index sesuai gambar (BTREE default)
            $table->index('id_tim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_tim_anggota');
    }
};
