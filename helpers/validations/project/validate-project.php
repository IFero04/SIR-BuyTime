<?php

function isProjectValid($req)
{
    foreach ($req as $key => $value) {
        $req[$key] =  trim($req[$key]);
    }

    if (empty($req['title'])) {
        $errors['title'] = 'The Title field cannot be empty.';
    }

    if (empty($req['description'])) {
        $errors['description'] = 'The Description field cannot be empty.';
    }

    if (empty($req['start_date'])) {
        $errors['start_date'] = 'The Start Date field cannot be empty.';
    }

    if (empty($req['end_date'])) {
        $errors['end_date'] = 'The End Date field cannot be empty.';
    }

    if (isset($errors)) {
        return ['invalid' => $errors];
    }

    return $req;
}

?>
