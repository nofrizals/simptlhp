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
        Schema::create('kis_nilai_kerugians', function (Blueprint $table) {
            $table->increments('id_nilai_kerugian');
            $table->string('nilai_kerugian', 255);
            $table->char('created_by', 20);
            $table->dateTime('created_at');
            $table->char('edited_by', 20)->nullable();
            $table->dateTime('edited_at')->nullable();
            $table->char('deleted_by', 20)->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_nilai_kerugians');
    }
};
