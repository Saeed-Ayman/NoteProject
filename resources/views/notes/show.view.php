<?php

use core\routes\Response;

Response::view('partials.header');
Response::view('partials.nav', ['heading' => "Note: {$note['title']}"]);
Response::view('partials.banner', ['heading' => "Note: {$note['title']}", 'slot' => 'notes.components.go-back-link']);
?>
    <article class="w-full flex flex-col justify-center items-center" style="height: calc(100vh - 145px)">
        <h1 class="text-xl"><?= $note['title'] ?></h1>
        <p><?= $note['body'] ?></p>
        <div class="mt-5 flex">
            <a href="/note/edit?id=<?= $note['id'] ?>"
               class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Edit
            </a>
            <form action="/note" method="post" class="mx-1">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value="<?= $note['id'] ?>">
                <button type="submit"
                        class="rounded-md bg-red-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700">
                    Delete
                </button>
            </form>
        </div>
    </article>
<?php Response::view('partials.footer'); ?>