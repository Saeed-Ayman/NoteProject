<?php

use core\routes\Response;

Response::view('partials.header');
Response::view('partials.nav');
Response::view('partials.banner', ['heading' => 'Notes', 'slot' => 'notes.components.banner-link-create']);
?>
    <article class="w-full flex justify-center items-center max-w-5xl m-auto" style="min-height: calc(100vh - 145px)">
        <?php if (empty($notes)): ?>
            <h1>Create your own notes.</h1>
        <?php else: ?>
            <ul class="w-full">
                <?php foreach ($notes as $note): ?>
                    <li class="flex justify-between bg-white p-4 m-4 rounded-2xl hover:shadow">
                        <a href="/note?id=<?= $note['id'] ?>" class="text-indigo-600 hover:text-indigo-400">
                            <?= $note['title'] ?>
                        </a>
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                data-dropdown-offset-skidding="-100"
                                class="rounded-md text-indigo-600 text-xs font-semibold hover:text-indigo-400"
                                type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdown"
                             class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg drop-shadow-2xl w-44">
                            <ul class="text-sm text-gray-700"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="/note?id=<?= $note['id'] ?>"
                                       class="block px-4 py-2 rounded-t-lg hover:bg-gray-100">Show</a>
                                </li>
                                <li>
                                    <a href="/note/edit?id=<?= $note['id'] ?>"
                                       class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                </li>
                            </ul>
                            <form action="/note" method="post" class="text-sm text-gray-700">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="<?= $note['id'] ?>">
                                <button type="submit" class="w-full text-left px-4 py-2 rounded-b-lg hover:bg-gray-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>
<?php Response::view('partials.footer'); ?>