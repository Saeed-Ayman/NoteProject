<?php

use app\http\requests\notes\UpdateNoteRequest;
use app\models\Note;
use core\main\Authenticator;
use core\routes\Response;
use core\validator\Validator;

$note = Validator::validate($_POST, UpdateNoteRequest::role());

Authenticator::authorize(Note::class, $note['id']);

Note::update($note, 'id = :id');

Response::abort(Response::ACCEPTED);
