<?php

use app\exceptions\ValidationException;
use core\database\Database;
use core\helpers\Helper;
use core\main\App;
use core\main\Container;
use core\main\Session;
use core\routes\Response;
use core\routes\Router;

Session::run();

App::setContainer(new Container);

App::bind(Database::class, function () {
    $databaseConfig = require(Helper::base_path('config/database.php'));

    return new Database($databaseConfig);
});

require(Helper::base_path('routes/app.php'));

try {
    Router::route();
} catch (ValidationException $e) {
    Session::flash('errors', $e->errors);
    Session::flash('old', $e->old);

    Response::redirect(Response::previousUrl());
} catch (Exception $e) {
    Response::abort(Response::SERVER_ERROR, $e->getMessage());
}

Session::unFlash();