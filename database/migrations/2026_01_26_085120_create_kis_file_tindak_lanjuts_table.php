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
        Schema::create('kis_file_tindak_lanjuts', function (Blueprint $table) {
            $table->id(); // int AUTO_INCREMENT PRIMARY KEY
            $table->integer('id_tindak_lanjut');
            $table->string('file', 200);
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_file_tindak_lanjuts');
    }
};
