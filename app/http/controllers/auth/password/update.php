<?php

use app\http\requests\auth\password\EditPasswordRequest;
use app\models\User;
use core\main\Authenticator;
use core\main\Session;
use core\routes\Response;
use core\routes\Router;
use core\validator\Validator;

$data = Validator::validate($_POST, EditPasswordRequest::role());

$data['email'] = Session::user('email');

if (!Authenticator::canLogin($data)) {
    Validator::throw(['password' => 'Wrong password.']);
}

User::update(
    ['password' => $data['new-password']],
    'email = :email',
    [':email' => $data['email']]
);

Response::redirect(Router::route('profile.settings'));
