<?php

use core\routes\Router;

Router::group(function () {
    Router::get('/login', 'auth.login.create')->name('login');
    Router::post('/login', 'auth.login.store');

    Router::get('/register', 'auth.register.create')->name('register');
    Router::post('/register', 'auth.register.store');

})->middleware('guest')->name('auth.');