<?php

use app\http\requests\auth\LoginRequest;
use core\main\Authenticator;
use core\routes\Response;
use core\routes\Router;
use core\validator\Validator;

$data = Validator::validate($_POST, LoginRequest::role());

if (!Authenticator::login($data)) {
    Validator::throw(['email' => 'No matching account found for that email and password.'], $_POST);
}

Response::redirect(Router::route('home'));
