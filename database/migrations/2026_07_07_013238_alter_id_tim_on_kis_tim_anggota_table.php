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
        Schema::table('kis_tim_anggota', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tim')->change();
            $table->foreign('id_tim')
                ->references('id')
                ->on('kis_tims')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kis_tim_anggota', function (Blueprint $table) {
            $table->dropForeign(['id_tim']);
            $table->integer('id_tim')->change();
            $table->index('id_tim');
        });
    }
};
