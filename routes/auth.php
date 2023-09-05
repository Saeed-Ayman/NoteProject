<?php

use core\routes\Router;


Router::resource('/note', 'notes')->middleware('auth');

Router::get('/profile/settings', 'profile.edit');
Router::post('/profile/update', 'profile.update');
Router::post('/profile/destroy', 'profile.destroy');

Router::post('/logout', 'auth.logout')->middleware('auth');