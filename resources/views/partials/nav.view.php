<?php

use core\helpers\Helper;

$pageIs = fn($name) => Helper::urlIs("/$name") ? "text-indigo-500" : "text-white";
$pageIs2 = fn($name) => Helper::urlIs("/$name") ? "text-white bg-indigo-600" : "text-gray-900 hover:bg-gray-50";
?>

<header class="bg-gray-900 text-white">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-3 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
            </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="/" class="text-sm font-semibold leading-6 <?= $pageIs('') ?>">Home</a>
            <?php if (Helper::isAuth()): ?>
                <a href="/notes" class="text-sm font-semibold leading-6 <?= $pageIs('notes') ?>">Notes</a>
            <?php endif; ?>
            <a href="/about" class="text-sm font-semibold leading-6 <?= $pageIs('about') ?>">About</a>
            <a href="/contact" class="text-sm font-semibold leading-6 <?= $pageIs('contact') ?>">Contact</a>
        </div>
        <div class="flex flex-1 justify-end content-center">
            <div>
                <?php if (Helper::isAuth()): ?>
                    <div class="sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false"
                             @close.stop="open = false">
                            <div @click="open = ! open">
                                <button class="inline-flex items-center rounded-md px-3 py-2 bg-indigo-600 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <div><?= $_SESSION['user']['name'] ?></div>

                                    <div>
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                                 style="display: none;"
                                 @click="open = false">
                                <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                    <a href="/profile/settings"
                                       class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Profile
                                    </a>

                                    <!-- Authentication -->
                                    <form method="POST" action="/logout">
                                        <input type="hidden" name="_method" value="POST">
                                        <button type="submit"
                                                class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login"
                       class="border-4 border-indigo-600 hover:bg-indigo-600 font-medium rounded-lg text-xs px-3 py-1 text-center mr-2">
                        Login
                    </a>
                    <a href="/register"
                       class="bg-indigo-600 border-4 border-indigo-600 hover:border-indigo-500 hover:bg-indigo-500 font-medium rounded-lg text-xs px-3 py-1">
                        Register
                    </a>
                <?php endif; ?>
            </div>
            <div class="flex lg:hidden mx-2">
                <button type="button" id="menu-btn"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="hidden" id="menu" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                         alt="">
                </a>
                <button type="button" id="menu-close-btn" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="/"
                           class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 <?= $pageIs2('') ?>">Home</a>
                        <?php if (Helper::isAuth()): ?>
                            <a href="/notes"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 <?= $pageIs2('notes') ?>">Notes</a>
                        <?php endif; ?>
                        <a href="/about"
                           class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 <?= $pageIs2('about') ?>">About</a>
                        <a href="/contact"
                           class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 <?= $pageIs2('contact') ?>">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
