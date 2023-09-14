<?php

use app\exceptions\ValidationException;
use core\database\Database;
use core\helpers\Helper;
use core\main\App;
use core\main\Container;
use core\main\Session;
use core\routes\Response;
use core\routes\Router;

Session::start();

App::setContainer(new Container);

App::bind(Database::class, function () {
    $databaseConfig = Helper::require('config\database.php');

    return new Database($databaseConfig);
});

Helper::require('routes\app.php');

try {
    Router::routes();
} catch (ValidationException $e) {
    Session::flash('form', Response::$current_route->name);
    Session::flash('errors', $e->errors);
    Session::flash('old', $e->old);

    Response::redirect(Response::previousUrl());
} catch (Exception $e) {
    Response::abort(Response::SERVER_ERROR, $e->getMessage());
}

Session::unFlash();