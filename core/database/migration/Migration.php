<?php

namespace core\database\migration;

abstract class Migration
{
    /**
     * Run the migrations.
     */
    public abstract function up(): void;

    /**
     * Reverse the migrations.
     */
    public abstract function down(): void;
}
