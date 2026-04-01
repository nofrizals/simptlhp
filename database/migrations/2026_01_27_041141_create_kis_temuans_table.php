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
        Schema::create('kis_temuans', function (Blueprint $table) {
            $table->id('id_temuan');
            $table->integer('id_kasus')->default(0);
            $table->text('temuan')->nullable();
            $table->integer('id_nilai_kerugian')->default(0);
            $table->decimal('besaran_kerugian', 20, 2)->default(0);
            $table->integer('id_nilai_kerugian2');
            $table->decimal('besaran_kerugian2', 20, 2)->default(0);
            $table->integer('id_nilai_kerugian3');
            $table->decimal('besaran_kerugian3', 20, 2)->default(0);
            $table->integer('id_nilai_kerugian4');
            $table->decimal('besaran_kerugian4', 20, 2)->default(0);
            $table->text('penyebab')->nullable();
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
        Schema::dropIfExists('kis_temuans');
    }
};
