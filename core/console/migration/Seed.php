<?php

namespace core\console\migration;

class Seed extends \core\console\Command
{
    private const FILE_PATH = 'database\seeders';

    public static array $commands = [
        'seed' => 'Indicates if the seed task should be re-run',
        'seeder' => 'The class name of the root seeder',
    ];

    public static function run(array $attr)
    {
        $command = array_key_first($attr);

        if (!isset(static::$commands[$command]))
            throw \core\console\ArtisanException::new("--$command");

        static::$command($attr[$command]);
    }

    private static function seed()
    {
        foreach (glob(static::FILE_PATH . '\*.php') as $filePath) {
            static::seeding($filePath);
        }
    }

    private static function seeder(string $fileName)
    {
        static::seeding(static::FILE_PATH . "\\$fileName.php");
    }

    private static function seeding(string $filePath)
    {
        $filePath = substr($filePath, 0, strlen($filePath) - 4);
        $fileName = substr(strrchr($filePath, '\\'), 1);

        echo "> Seeding $fileName \t";
        /**
         * @var \core\database\seeder\Seeder $seeder
         */
        $seeder = new $filePath();
        $seeder->run();

        echo "[Done]\n";
    }
}
