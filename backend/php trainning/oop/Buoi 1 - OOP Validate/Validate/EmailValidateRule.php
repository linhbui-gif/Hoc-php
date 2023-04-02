<?php
require_once __DIR__ . '/ValidateRule.php';
class EmailValidateRule extends ValidateRule {
   private $fieldValue;
    public function __construct( $fieldValue){
        $this->fieldValue = $fieldValue;
    }
    public function passedValidate(){
        if (!filter_var($this->fieldValue, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    public function getMessage() {
        return 'not valid Email';
    }
}