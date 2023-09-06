<?php

namespace app\http\middleware;

use core\routes\Closure;
use core\routes\Response;

class Guest implements Middleware
{
    public function handle(Closure $next): void
    {
        if (isset($_SESSION["user"])) Response::redirect('/');

        $next();
    }
}