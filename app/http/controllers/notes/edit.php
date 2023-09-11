<?php

use app\models\Note;
use core\main\Authenticator;
use core\routes\Response;

if (!isset($_POST['id'])) Response::abort();

$note = Authenticator::authorize(Note::class, $_POST['id']);

Response::view('notes.edit', compact('note'));
