<?php

use app\http\requests\profile\DestroyProfileRequest;
use app\models\User;
use core\helpers\Helper;
use core\main\Authenticator;
use core\main\Session;
use core\routes\Response;
use core\validator\Validator;


$user = Validator::validate($_POST, DestroyProfileRequest::role());

$user['email'] = Session::user('email');

if (!Authenticator::canLogin($user)) {
    Validator::throw(['password' => 'Wrong password.']);
}

User::delete('id = :id', ['id' => Session::user('id')]);

Authenticator::logout();

Response::redirect('/');