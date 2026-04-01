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
        Schema::create('kis_access_log', function (Blueprint $table) {
            $table->char('id_session', 36)->primary();
            $table->string('id_pegawai', 36);
            $table->string('kode_unor', 12)->nullable();
            $table->integer('level')->nullable();
            $table->dateTime('login_at');
            $table->dateTime('valid_thru');
            $table->dateTime('logout_at')->nullable();
            $table->string('browser', 255);
            $table->string('platform', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kis_access_log');
    }
};
