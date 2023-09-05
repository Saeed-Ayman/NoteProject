<?php

use core\routes\Router;

Router::get('/', 'index');
Router::get('/about', 'about');
Router::get('/contact', 'contact');

require('auth.php');
require('guest.php');
