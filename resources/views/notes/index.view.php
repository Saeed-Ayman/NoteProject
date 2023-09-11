<?php

use core\routes\Response;
use core\routes\Router;

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'Notes', 'slot' => 'notes.components.banner-link-create']);
?>
<article class="w-full flex justify-center items-center max-w-5xl m-auto" style="min-height: calc(100vh - 145px)">
    <?php if (empty($notes)) : ?>
        <h1>Create your own notes.</h1>
    <?php else : ?>
        <ul class="w-full">
            <?php foreach ($notes as $note) : ?>
                <li class="flex justify-between bg-white p-4 m-4 rounded-2xl hover:shadow">
                    <a href="<?= Router::route('notes.show') . "?id={$note['id']}" ?>" class="text-indigo-600 hover:text-indigo-400">
                        <?= $note['title'] ?>
                    </a>
                    <?php Response::view('notes.components.dropdown', ['id' => $note['id']]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</article>
<?php Response::view('partials.footer'); ?>