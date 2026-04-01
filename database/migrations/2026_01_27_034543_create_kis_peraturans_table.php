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
        Schema::create('kis_peraturans', function (Blueprint $table) {
            $table->increments('id_peraturan'); // int, auto increment, primary key
            $table->string('judul', 255); // varchar(255)
            $table->text('keterangan')->nullable(); // text, null
            $table->text('file')->nullable(); // text, null
            $table->dateTime('created_at'); // datetime, not null
            $table->string('created_by', 25); // varchar(25), not null
            $table->dateTime('edited_at')->nullable(); // datetime, null
            $table->string('edited_by', 25)->nullable(); // varchar(25), null
            $table->dateTime('deleted_at')->nullable(); // datetime, null
            $table->string('deleted_by', 25)->nullable(); // varchar(25), null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_peraturans');
    }
};
