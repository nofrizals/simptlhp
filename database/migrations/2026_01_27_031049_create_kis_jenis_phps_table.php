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
        Schema::create('kis_jenis_phps', function (Blueprint $table) {
            $table->id('id_jenis_php');
            $table->string('jenis_php', 255);
            $table->dateTime('created_at');
            $table->char('created_by', 16);
            $table->dateTime('edited_at')->nullable();
            $table->char('edited_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->char('deleted_by', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_jenis_phps');
    }
};
