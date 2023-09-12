<?php

namespace core\console;

use core\database\Database;
use core\helpers\Helper;
use core\helpers\Str;

class Main
{
    public static function run($args)
    {
        @[$command, $attr] = Str::split($args[1], ':', 1);

        switch ($command) {
            case 'serve':
                return static::serve();
            case 'migrate':
                return static::migrate($attr);
            default:
                echo "
                serve: open server port=8888\n
                migrate: create tables in db with files in database/migration
                ";
        }
    }

    private static function serve($port = 8888)
    {
        exec("php -S localhost:$port -t public");
    }

    private static function migrate(string|null $attr = null)
    {
        $files = glob(Helper::base_path("database/migrations/*.php"));

        $config = require(Helper::base_path('config\database.php'));
        try {
            new Database($config);
        } catch (\Exception $e) {
            echo "> Database not found. Creating database.\n";
            Database::CreateDB($config['host'], $config['dbname']);
        }

        if ($attr == 'fresh') {
            for ($i = count($files) - 1; $i >= 0; $i--) {
                /**
                 * @var \core\database\migration\Migration $migration 
                 */
                $migration = (new (require($files[$i]))());

                $migration->down();
            }
        }

        foreach ($files as $file) {
            /**
             * @var \core\database\migration\Migration $migration 
             */
            $migration = (new (require($file))());

            $migration->up();
        }
    }
}
