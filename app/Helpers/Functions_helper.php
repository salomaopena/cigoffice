<?php

function display_error($field, $errors)
{
    if (empty($errors)) {
        return;
    }

    if (array_key_exists($field, $errors)) {
        // return the error message for the specified field only if it exists in the errors array
        return'<div class="text-danger fw-bold" role="alert"><small> <i class="fa-regular fa-circle-xmark me-1 mt-1"></i>'. $errors[$field]. '</small></div>';
    }
}
