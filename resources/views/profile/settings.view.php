<?php

use core\helpers\Helper;
use core\main\Session;
use core\routes\Response;

$errors = Session::get('errors');
$user = Session::get('user');

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'Profile']);
?>

<div class="w-full flex flex-col justify-center items-center max-w-5xl m-auto" style="min-height: calc(100vh - 145px)">
    <?php
    Response::view('profile.partial.edit', compact('user', 'errors'));
    Response::view('profile.partial.edit-password', compact('user', 'errors'));
    Response::view('profile.partial.destroy', compact('user', 'errors'));
    ?>
</div>

<?php

$script = $errors === null ? '' : (
isset($errors['password']) ?
    "<script>window.addEventListener('load', () => document.getElementById('delete-account-btn').click())</script>" :
    "<script>window.addEventListener('load', () => document.getElementById('edit-info-btn').click())</script>"
);

$script = '';


switch (Response::previousUrl()) {

}


Response::view('partials.footer', compact('script'));
Helper::dd(Response::previousUrl(), $_SERVER);

?>
