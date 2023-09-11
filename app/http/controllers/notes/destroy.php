<?php

use app\models\Note;
use core\helpers\Helper;
use core\main\Authenticator;
use core\routes\Response;
use core\routes\Router;

$data = Authenticator::authorize(Note::class, $_POST['id']);

Note::delete('id = :id', ['id' => $data['id']]);

Response::redirect(Router::route('notes.index'));
