<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index('priority');
            $table->index('category_id');
        });

        Schema::table('ticket_comments', function (Blueprint $table) {
            $table->index('ticket_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['assigned_to']);
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['category_id']);
        });

        Schema::table('ticket_comments', function (Blueprint $table) {
            $table->dropIndex(['ticket_id']);
            $table->dropIndex(['user_id']);
        });
    }
}; 