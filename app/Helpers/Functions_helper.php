<?php

function display_error($field, $errors)
{
    if (empty($errors)) {
        return;
    }

    if (array_key_exists($field, $errors)) {
        // return the error message for the specified field only if it exists in the errors array
        return '<div class="text-danger fw-bold" role="alert"><small> <i class="fa-regular fa-circle-xmark me-1 mt-1"></i>' . $errors[$field] . '</small></div>';
    }
}

function calculate_promotion($price, $discount)
{

    if ($discount == 0) {
        return $price;
    }

    return round($price - ($price * $discount) / 100, 2);
}

function normalize_price($price){
    return number_format($price, 2, ',', '.');
}


function prefixed_product_file_name($file_name){
    //create a prefix file name
    $prefix = 'rest_'.str_pad(session()->user['id_restaurant'],5,'0',STR_PAD_LEFT);
    //rest_00001_2025012201_image.png
    return $prefix.'_'.date('Ymd_His').'_'.$file_name;
}

function print_data($data,$die = true){
   echo('<pre>');
   echo(str_repeat('-',40).'<br>');
   echo print_r($data,true);
   echo('<br>');
   echo(str_repeat('-',40).'<br>');
   echo('</pre>');
   if($die){
       die(1);
   }
}
