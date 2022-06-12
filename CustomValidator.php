<?php
class CustomValidator extends Validator
{
    public function min($input, $fieldName, $value) 
    {
        if(isset($input[$fieldName]) && strlen($input[$fieldName]) < $value) {
            return " min message";
        } else {
            return false;
        }
    }
}