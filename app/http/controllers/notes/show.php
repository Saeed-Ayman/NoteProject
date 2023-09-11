<?php

use app\models\Note;
use core\helpers\Helper;
use core\main\Authenticator;
use core\routes\Response;

if (!isset($_GET['id'])) Response::abort();

$note = Authenticator::authorize(Note::class, $_GET['id']);

Response::view('notes.show', compact('note'));

