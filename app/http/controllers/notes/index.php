<?php

use app\models\Note;
use core\main\Session;
use core\routes\Response;

$notes = Note::all()->where('user_id = :id', ['id' => Session::user('id')])->get();

Response::view('notes.index', compact('notes'));
