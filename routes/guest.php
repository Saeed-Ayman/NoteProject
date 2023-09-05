<?php

use core\routes\Router;

Router::get('/login', 'auth.login.create')->middleware('guest');
Router::post('/login', 'auth.login.store')->middleware('guest');

Router::get('/register', 'auth.register.create')->middleware('guest');
Router::post('/register', 'auth.register.store')->middleware('guest');
