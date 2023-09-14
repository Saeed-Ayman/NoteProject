<?php

namespace core\console\migration;

use core\console\Command;
use core\database\Database;
use core\database\DB;
use core\database\migration\Migration;
use core\database\QueryBuilder;
use core\helpers\Helper;
use core\main\App;
use core\main\Container;

class Migrate extends Command
{
    private static Database $db;

    public const FILE_PATH = 'database\migrations';
    public const DB_CONFIG = 'config\database.php';

    public static array $commands = [
        // [command] => [description]
        'default' => 'Run all migrations', // 'migrate function'
        'install' => 'Create the migration repository',
        'fresh' => 'Drop all tables and re-run all migrations',
        'rollback' => 'Rollback the last database migration',
        'reset' => 'Rollback all database migrations',
        'refresh' => 'Reset and re-run all migrations',
        'status' => 'Show the status of each migration',
    ];

    public static array $options = [
        // [option] => [needInput[true/false], class]
        '--seed' => [false, \core\console\migration\Seed::class],
        '--seeder' => [true, \core\console\migration\Seed::class],
    ];

    public static function run(array $attr)
    {
        $command = $attr['command'] ?? 'migrate';

        if ($command !== 'migrate' && !isset(static::$commands[$command]))
            throw \core\console\ArtisanException::new("migrate:$command");

        Migrate::prepareDB(!($command === 'install' || $command === 'fresh'));
        Migrate::$command();
    }

    private static function prepareDB(bool $withMigrationTable)
    {
        $config = Helper::require(static::DB_CONFIG);
        $dbIsExists = Database::tryConnection($config['host'], $config['dbname']);

        App::setContainer(new Container());
        App::bind(Database::class, function () {
            $databaseConfig = Helper::require(static::DB_CONFIG);

            return new Database($databaseConfig);
        });

        static::$db = App::resolver(Database::class);

        if ((!$dbIsExists || !static::$db->containTable('migrations')) && $withMigrationTable) {
            static::install();
        }
    }

    private static function migrate()
    {
        $files =  static::migrationFiles();
        $batch = static::currentBatch() + 1;
        $oldMigrations = static::oldMigrations();

        foreach ($files as $file) {
            if (in_array($file, $oldMigrations)) continue;

            echo "> Creating table $file \t";

            /**
             * @var \core\database\migration\Migration $migration 
             */
            $migrateTable = (new (Helper::require(static::FILE_PATH . "\\$file.php"))());
            $migrateTable->up();

            DB::insert(
                'migrations',
                ['migration', 'batch'],
                ['migration' => $file, 'batch' => $batch]
            );

            echo "[Done]\n";
        }
    }

    private static function install()
    {
        /**
         * @var \core\database\migration\Migration $migration
         */
        echo "> Creating migrations table. \t";
        $migration = new (Helper::require('core\console\migration\MigrateTable.php'));
        $migration->up();
        echo "[Done]\n";
    }

    private static function fresh()
    {
        // TODO: this function make race condition
        static::$db->dropAllTables();
        sleep(1);
        static::install();
        static::migrate();
    }

    private static function rollback()
    {
        $oldMigrations = static::oldMigrations(static::currentBatch(), true);
        static::rollbackTables($oldMigrations);
    }

    private static function reset()
    {
        static::rollbackTables(static::oldMigrations(desc: true));
    }

    private static function refresh()
    {
        static::reset();
        static::migrate();
    }

    private static function status()
    {
        $files = static::migrationFiles();

        foreach (static::oldMigrations(withBatch: true) as $m) {
            $i = array_search($m['migration'], $files);

            if ($i === null) {
                echo "{$m['migration']} \t[{$m['batch']}] Ran-Del\n";
                continue;
            }

            unset($files[$i]);
            echo "{$m['migration']} \t[{$m['batch']}] Ran\n";
        }

        foreach ($files as $f) {
            echo "$f \tPending\n";
        }
    }

    private static function currentBatch()
    {
        return (new QueryBuilder('migrations'))->all(['MAX(batch) AS MAX'])->find()['MAX'] ?? 0;
    }

    private static function oldMigrations(int|null $batch = null, $desc = false, $withBatch = false)
    {
        $builder = new QueryBuilder('migrations');
        $builder->all(['migration']);

        if ($batch) $builder->where("batch = $batch");
        if ($desc) $builder->orderBy('migration', false);

        if ($withBatch) return $builder->all(['batch'])->get() ?: [];

        return array_map(fn ($m) => $m['migration'], $builder->get() ?: []);
    }

    private static function migrationFiles()
    {
        return array_map(
            function ($file) {
                $fileName = strrchr($file, '\\');
                return substr($fileName, 1, strlen($fileName) - 5);
            },
            glob(Helper::base_path(static::FILE_PATH . '\*.php'))
        );
    }

    private static function rollbackTables(array $migrations)
    {
        foreach ($migrations as $migration) {
            echo "> Dropping table $migration. \t";
            /**
             * @var Migration $migrateTable
             */
            $migrateTable = new (Helper::require(static::FILE_PATH . "\\$migration.php"));
            $migrateTable->down();

            DB::delete('migrations', "migration = '$migration'");

            echo "[Done]\n";
        }
    }
}
