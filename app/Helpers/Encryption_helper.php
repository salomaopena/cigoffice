<?php

use \Config\Services;

function Encrypt($value){
    if(empty($value)){
        return null;
    }else{
        try {
            
            // Get encryption service instance
            //$encryption = service('encrypter');
            $encryption = Services::encrypter();

            return bin2hex($encryption->encrypt($value));

        } catch (Exception $e) {
            return null;
        }
    }
}

function Decrypt($value){
    if(empty($value)){
        return null;
    }else{
        try {
            
            // Get encryption service instance
            //$encryption = service('encrypter');
            $encryption = Services::encrypter();

            return $encryption->decrypt(hex2bin($value));

        } catch (Exception $e) {
            return null;
        }
    }
}