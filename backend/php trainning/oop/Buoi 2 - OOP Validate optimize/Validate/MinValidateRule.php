<?php
require_once __DIR__ . '/ValidateRule.php';
class MinValidateRule extends ValidateRule
{
    private $min;
    public function __construct($min)
    {
       $this->min = $min;
    }

    public function passedValidate($fieldName,$valueRule)
    {
        if(strlen($this->min) <= $valueRule){
            return true;
        }
        return false;
    }

    public function getMessage($fieldName,$message)
    {
        if($message){
            return $message;
        }
       return $fieldName . ' must have min '. $this->min . ' character';
    }
}