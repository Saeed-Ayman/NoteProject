<?php

namespace core\console;

use core\database\Database;
use core\helpers\Helper;

class Migrate extends Command
{
    public static Database $db;

    public const MAP = [
        'migrate',
        'fresh',
        'install'
    ];

    public static function run(array $attr)
    {
        Migrate::prepareDB();

        $command = $attr['command'] ?? 'migrate';

        Migrate::$command();
    }

    private static function prepareDB()
    {
        $config = require(Helper::base_path('config\database.php'));
        $dbIsExists = Database::tryConnection($config['host'], $config['dbname']);
        static::$db = new Database($config);

        if (!$dbIsExists || !static::$db->containTable('migrations')) {
            static::install();
        }
    }

    private static function freshDB()
    {
        static::$db->dropAllTables();
        static::install();
    }

    private static function fresh()
    {
        static::freshDB();
        static::migrate();
    }

    private static function install()
    {
        /**
         * @var \core\database\migration\Migration $migration
         */
        $migration = new (require(Helper::base_path('core\console\MigrateTable.php')));
        $migration->up();
    }

    private static function migrate()
    {
        $files = glob(Helper::base_path("database\migrations\*.php"));

        foreach ($files as $file) {
            /**
             * @var \core\database\migration\Migration $migration 
             */
            $migration = (new (require($file))());

            $migration->up();
        }
    }
}
