<?php

use app\models\Note;
use core\main\Authenticator;
use core\routes\Response;

$data = Authenticator::authorize(Note::class, $_POST['id']);

Note::delete('id = :id', ['id' => $data['id']]);

Response::abort(Response::ACCEPTED);



