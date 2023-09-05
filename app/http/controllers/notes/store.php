<?php

use app\http\requests\notes\StoreNoteRequest;
use app\models\Note;
use core\main\Session;
use core\routes\Response;
use core\validator\Validator;

Validator::validate($_POST, StoreNoteRequest::role());

Validator::addData(['user_id' => Session::user('id')]);

Note::create(Validator::validData());

Response::abort(Response::CREATED_SUCCESSFULLY);




