<?php

use core\routes\Response;

?>
<div class="w-full p-4 px-8 bg-white shadow">
    <div class="flex justify-between max-w-7xl m-auto">
        <p class="text-lg font-bold">
            <?= $heading ?? '' ?>
        </p>
        <?php if (isset($slot)) Response::view($slot) ?>
    </div>
</div>