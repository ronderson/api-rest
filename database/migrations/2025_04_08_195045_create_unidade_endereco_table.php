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
        Schema::create('unidade_endereco', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unid_id');
            $table->unsignedBigInteger('end_id');

            // Define chaves estrangeiras
            $table->foreign('unid_id')->references('unid_id')->on('unidade')->onDelete('cascade');
            $table->foreign('end_id')->references('end_id')->on('endereco')->onDelete('cascade');

            // Evita duplicação
            $table->unique(['unid_id', 'end_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidade_endereco');
    }
};
