<?php

namespace app\http\middleware;

use core\routes\Closure;

interface Middleware
{
    public function handle(Closure $next): void;
}