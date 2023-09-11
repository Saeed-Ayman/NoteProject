<?php

namespace database\core;

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
