<?php

use app\http\requests\profile\UpdateProfileRequest;
use app\models\User;
use core\main\Authenticator;
use core\main\Session;
use core\routes\Response;
use core\validator\Validator;

$user = Validator::validate($_POST, UpdateProfileRequest::role());

$user['id'] = Session::user('id');

User::update($user, 'id = :id');

Authenticator::attempted($user);

Response::abort(Response::ACCEPTED);