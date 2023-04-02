<?php
require_once __DIR__ . '/ValidateRule.php';
class EmailValidateRule extends ValidateRule {
    public function passedValidate($fieldName,$valueRule){
        if (filter_var($valueRule, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public function getMessage($fieldName,$message) {
        if($message){
            return $message;
        }
        return $fieldName . ' not valid Email';
    }
}