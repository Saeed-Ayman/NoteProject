<?php

use core\main\Authenticator;
use core\routes\Response;
use core\routes\Router;

Authenticator::logout();

Response::redirect(Router::route('home'));
