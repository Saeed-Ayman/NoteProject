<?php

use core\main\Session;
use core\routes\Response;

$errors = Session::get('errors');
$user = Session::get('user');
$form = Session::get('form');

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'Profile']);

echo '<div class="w-full flex flex-col justify-center items-center max-w-5xl m-auto" style="min-height: calc(100vh - 145px)">';
Response::view('profile.partial.edit', [
    'user' => $user,
    'errors' => $form === 'profile.update' ? $errors : [],
]);
Response::view('profile.partial.edit-password', [
    'user' => $user,
    'errors' => $form === 'auth.password.update' ? $errors : [],
]);
Response::view('profile.partial.destroy', [
    'user' => $user,
    'errors' => $form === 'profile.destroy' ? $errors : [],
]);
echo '</div>';

$script = !$form ? '' :
    "<script> window.addEventListener('load', () => document.getElementById('" .
    match ($form) {
        'profile.update' => 'edit-info',
        'auth.password.update' => 'edit-password',
        'profile.destroy' => 'delete-account',
        default => ''
    } .
    "-btn').click()) </script>";

Response::view('partials.footer', compact('script'));