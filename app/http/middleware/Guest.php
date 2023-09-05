<?php

namespace app\http\middleware;

use core\routes\Response;

class Guest implements Middleware
{
    public function handle(): void
    {
        if (isset($_SESSION["user"])) Response::redirect('/');
    }
}