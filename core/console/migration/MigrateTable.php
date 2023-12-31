<?php

namespace core\console\migration;

use core\database\migration\Blueprint;
use core\database\migration\Schema;

return new class extends \core\database\migration\Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('migrations');
    }
};
