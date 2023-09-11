<?php

use core\main\Session;
use core\routes\Response;
use core\routes\Router;

$errors = Session::get('errors');

Response::view('partials.header');
?>
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <a href="<?= Router::route('home') ?>">
            <img class="mx-auto h-10 w-auto"
                 src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                 alt="Your Company">
        </a>
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create new account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-xl">
        <form class="space-y-6" action="<?= Router::route('auth.register') ?>" method="POST">
            <input type="hidden" name="_method" value="POST">
            <div class="flex sm:space-x-2 max-sm:space-y-6 max-sm:flex-col w-full">

                <div class="w-full">
                    <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                    <div class="mt-2">
                        <input id="first_name" name="first_name" type="text" autocomplete="first_name"
                               value="<?= Session::old('first_name') ?>"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?php if (isset($errors['first_name'])): ?>
                        <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50"
                             role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <?= $errors['first_name'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="w-full">
                    <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                    <div class="mt-2">
                        <input id="last_name" name="last_name" type="text" autocomplete="last_name"
                               value="<?= Session::old('last_name') ?>"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?php if (isset($errors['last_name'])): ?>
                        <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50"
                             role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <?= $errors['last_name'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input id="email" name="email" type="text" autocomplete="email"
                           value="<?= Session::old('email') ?>"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <?php if (isset($errors['email'])): ?>
                    <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50"
                         role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <?= $errors['email'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <?php if (isset($errors['password'])): ?>
                    <div class="flex items-center px-5 py-2 my-1 text-xs text-red-800 rounded-lg bg-red-50"
                         role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <?= $errors['password'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Register
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Member?
            <a href="<?= Router::route('auth.login') ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login</a>
        </p>
    </div>
</div>
<?php Response::view('partials.footer') ?>
