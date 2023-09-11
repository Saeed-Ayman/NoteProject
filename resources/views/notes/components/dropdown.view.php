<?php

use core\routes\Router;
?>
<button id="dropdownDefaultButton-<?= $id ?>" data-dropdown-toggle="dropdown-<?= $id ?>" data-dropdown-offset-skidding="-100" class="rounded-md text-indigo-600 text-xs font-semibold hover:text-indigo-400" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
    </svg>
</button>
<!-- Dropdown menu -->
<div id="dropdown-<?= $id ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg drop-shadow-2xl w-44">
    <ul class="text-sm text-gray-700" aria-labelledby="dropdownDefaultButton-<?= $id ?>">
        <li>
            <a href="<?= Router::route('notes.show') . '?id=' . $id ?>" class="block px-4 py-2 rounded-t-lg hover:bg-gray-100">
                Show
            </a>
        </li>
        <li>
            <form action="<?= Router::route('notes.edit') ?>" method="post">
                <input type="hidden" name="_method" value="GET">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="w-full text-left block px-4 py-2 hover:bg-gray-100">
                    Edit
                </button>
            </form>
        </li>
    </ul>
    <form action="<?= Router::route('notes.destroy') ?>" method="post" class="text-sm text-gray-700">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" class="w-full text-left px-4 py-2 rounded-b-lg hover:bg-gray-100">
            Delete
        </button>
    </form>
</div>