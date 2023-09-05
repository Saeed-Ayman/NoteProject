<?php

use app\models\User;
use core\main\Session;
use core\routes\Response;

$user = User::all(['first_name', 'last_name', 'email'])
    ->where('id = :id', ['id' => Session::user('id')])
    ->find();

Session::flash('user', $user);

Response::view('profile.settings');
