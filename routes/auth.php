<?php

use core\routes\Router;

Router::group(function () {
    Router::resource('note', 'notes');

    Router::group(function () {
        Router::get('/settings', 'profile.edit')->name('settings');
        Router::put('/update', 'profile.update')->name('update');
        Router::delete('/destroy', 'profile.destroy')->name('destroy');
    })->name('profile.')->prefix('/profile');

    Router::put('/password/update', 'auth.password.update')->name('auth.password.update');
    Router::post('/logout', 'auth.logout')->middleware('auth')->name('auth.logout');
})->middleware('auth');
