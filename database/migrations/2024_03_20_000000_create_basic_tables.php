<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Criar tabela de categorias
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Criar tabela de tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->string('status');
            $table->string('priority');
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        // Criar tabela de comentários
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('categories');
    }
}; 