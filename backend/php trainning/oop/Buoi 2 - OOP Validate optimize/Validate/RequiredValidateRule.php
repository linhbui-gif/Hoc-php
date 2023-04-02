<?php
require_once __DIR__ . '/ValidateRule.php';
class RequiredValidateRule extends ValidateRule {
   public function passedValidate($fieldName,$valueRule)
   {
       if($valueRule){
           return true;
       }
       return false;
   }
   public function getMessage($fieldName,$message) {
       if($message){
           return $message;
       }
       return $fieldName . ' not Empty';
   }
}