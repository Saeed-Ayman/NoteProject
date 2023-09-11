<?php

use core\main\Session;
use core\routes\Response;
use core\routes\Router;

$errors = Session::get('errors');

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'Create Note', 'slot' => 'notes.components.go-back-link']);
?>
<article class="w-full flex flex-col justify-center items-center max-w-2xl m-auto" style="min-height: calc(100vh - 145px)">
    <form action="<?= Router::route('notes.store') ?>" method="POST" class="mx-2 my-10 w-full p-10">
        <input type="hidden" name="user_id" value="1">

        <p class="text-base font-semibold leading-7 text-gray-900">
            Don't worry this note is displayed privately to you.
        </p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" autocomplete="title" aria-label="Title" value="<?= Session::old('title') ?>" class="block w-full rounded p-1 border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <?php if (isset($errors['title'])) : ?>
                    <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <?= $errors['title'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-span-full">
                <label for="body" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                <div class="mt-2">
                    <textarea id="body" name="body" rows="3" autocomplete="description" aria-label="Description" class="block w-full rounded border-0 p-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?= Session::old('body') ?></textarea>
                </div>
                <?php if (isset($errors['body'])) : ?>
                    <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <?= $errors['body'] ?>
                    </div>
                <?php endif; ?>
                <p class="mt-3 text-sm leading-6 text-gray-600">Write a few notes to remind yourself.</p>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-end gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>
</article>
<?php Response::view('partials.footer'); ?>