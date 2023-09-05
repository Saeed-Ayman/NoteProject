<?php

use app\http\requests\auth\RegisterRequest;
use core\main\Authenticator;
use core\routes\Response;
use core\validator\Validator;

$data = Validator::validate($_POST, RegisterRequest::role());

if (Authenticator::register($data) && Authenticator::login($data)) {
    Response::redirect('/');
}

Response::abort(Response::SERVER_ERROR);