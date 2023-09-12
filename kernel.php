<?php

use core\helpers\Helper;

const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;

require(BASE_PATH . 'core\helpers\Helper.php');

spl_autoload_register(function (string $class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require Helper::base_path("$class.php");
});
