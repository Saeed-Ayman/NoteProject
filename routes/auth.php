<?php

use core\routes\Router;


Router::resource('/note', 'notes')->middleware('auth');

Router::get('/profile/settings', 'profile.edit')->middleware('auth')->name('profile.edit');
Router::post('/profile/update', 'profile.update')->middleware('auth')->name('profile.update');
Router::post('/profile/destroy', 'profile.destroy')->middleware('auth')->name('profile.destroy');
Router::post('/password/update', 'auth.password.update')->middleware('auth')->name('auth.password.update');

Router::post('/logout', 'auth.logout')->middleware('auth');