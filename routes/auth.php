<?php

use core\routes\Router;


Router::resource('/note', 'notes')->middleware('auth');

Router::get('/profile/settings', 'profile.edit')->middleware('auth');
Router::post('/profile/update', 'profile.update')->middleware('auth');
Router::post('/profile/destroy', 'profile.destroy')->middleware('auth');
Router::post('/password/update', 'auth.password.update')->middleware('auth');

Router::post('/logout', 'auth.logout')->middleware('auth');