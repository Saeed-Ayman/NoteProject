<?php

use core\routes\Router;

Router::get('/', 'index')->name('home');
Router::get('/about', 'about')->name('about');
Router::get('/contact', 'contact')->name('contact');

require('auth.php');
require('guest.php');
