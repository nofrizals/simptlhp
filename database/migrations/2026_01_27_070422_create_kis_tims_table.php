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
        Schema::create('kis_tims', function (Blueprint $table) {
            $table->id(); // id int AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 255);
            $table->string('nip_ketua', 20)->nullable();
            $table->string('created_by', 255);
            $table->dateTime('created_at');
            $table->string('edited_by', 255)->nullable();
            $table->dateTime('edited_at')->nullable();
            $table->string('deleted_by', 255)->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_tims');
    }
};
