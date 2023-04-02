<?php
require_once __DIR__ . '/ValidateRule.php';
class BetweenValidateRule extends ValidateRule
{
    private $min;
    private $max;
    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function passedValidate($fieldName,$valueRule)
    {
      if(strlen($this->min) <= $valueRule && $valueRule <= strlen($this->max)){
          return true;
      }
      return false;
    }

    public function getMessage($fieldName,$message)
    {
        if($message){
            return $message;
        }
        return $fieldName . ' must between ' . $this->min . ' and ' . $this->max .' character';
    }
}