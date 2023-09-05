<?php

use core\routes\Response;

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'About']);
?>
    <article class="w-full flex justify-center items-center" style="height: calc(100vh - 145px)">
        <h1>About</h1>
    </article>
<?php Response::view('partials.footer') ?>