<?php

namespace core\console;

use core\helpers\Helper;
use core\helpers\Str;

class Main extends Command
{
    public static array $commands = [
        'serve' => \core\console\Serve::class,
        'migrate' => \core\console\migration\Migrate::class,
    ];

    public static array $options = [];

    public static function run($args)
    {
        @[$command, $attr] = Str::split($args[1], ':', 1);

        $command = static::$commands[$command] ?? false;

        if (!$command)
            throw ArtisanException::new($command);

        /**
         * @var Command $command
         */
        $command = new $command();
        $attrs = [];
        $options = [];

        if ($attr) {
            if (!isset($command::$commands[$attr]))
                throw ArtisanException::new($attr);

            $attrs['command'] = $attr;
        }

        for ($i = 2; $i < count($args); $i++) {
            @[$option, $assign] =  Str::split($args[$i], '=', 1);

            if (!isset($command::$options[$option]) || ($command::$options[$option][0] !== isset($assign))) {
                throw ArtisanException::new($option . (isset($assign) ? "=$assign" : ''));
            }

            $options[$option] = $assign;
        }

        $command->run($attrs);

        // run options
        foreach ($options as $option => $assign) {
            /**
             * @var Command $class
             */
            $class = new ($command::$options[$option][1]);
            $class->run([substr($option, 2) => $assign]);
        }
    }
}
