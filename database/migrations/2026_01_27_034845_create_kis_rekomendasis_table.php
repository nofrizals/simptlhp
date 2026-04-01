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
        Schema::create('kis_rekomendasis', function (Blueprint $table) {
            $table->increments('id_rekomendasi'); // int, auto increment
            $table->integer('id_temuan')->default(0); // int, not null, default 0
            $table->text('rekomendasi')->nullable(); // text, null
            $table->dateTime('created_at'); // datetime, not null
            $table->string('created_by', 20); // varchar(20), not null
            $table->dateTime('edited_at')->nullable(); // datetime, null
            $table->string('edited_by', 20)->nullable(); // varchar(20), null
            $table->dateTime('deleted_at')->nullable(); // datetime, null
            $table->string('deleted_by', 20)->nullable(); // varchar(20), null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_rekomendasis');
    }
};
