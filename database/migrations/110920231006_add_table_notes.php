<?php

use core\database\migration\Blueprint;
use core\database\migration\Migration;
use core\database\migration\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('body');
            $table->forginId('user_id', 'id', 'users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notes');
    }
};
