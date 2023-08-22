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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->longText('thumb')->nullable();
            $table->string('titulo')->nullable();
            $table->date('data_publicacao')->nullable();
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->longText('arquivo')->nullable();
            $table->integer('nota')->nullable();
            $table->longText('assunto')->nullable();
            $table->string('tipo')->nullable();
            $table->string('lingua')->nullable();
            $table->string('licenca')->nullable();
            $table->timestamps();
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
