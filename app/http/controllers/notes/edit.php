<?php

use app\models\Note;
use core\main\Authenticator;
use core\routes\Response;

$note = Authenticator::authorize(Note::class, $_GET['id']);

Response::view('notes.edit', compact('note'));