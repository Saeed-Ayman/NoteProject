<?php

use core\main\Authenticator;
use core\routes\Response;

Authenticator::logout();

Response::redirect('/');