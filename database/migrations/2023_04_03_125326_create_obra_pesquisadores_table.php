<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obra_pesquisadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obra_id')->nullable();
            $table->unsignedBigInteger('pesquisador_id')->nullable();
            $table->timestamps();
            $table->foreign('obra_id')->references('id')->on('obras');
            $table->foreign('pesquisador_id')->references('id')->on('pesquisadores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obra_pesquisadores');
    }
};
