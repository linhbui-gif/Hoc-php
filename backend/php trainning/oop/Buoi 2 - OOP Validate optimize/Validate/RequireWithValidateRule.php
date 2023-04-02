<?php
require_once __DIR__ . '/ValidateRule.php';
class RequireWithValidateRule
{
    private $fieldNameRequireWith;
    public function __construct($fieldNameRequireWith)
    {
        $this->fieldNameRequireWith = $fieldNameRequireWith;
    }

    public function passedValidate($fieldName,$valueRule, $dataForm)
    {
      if($valueRule && !$dataForm[$this->fieldNameRequireWith]){
          return false;
      }
      return true;
    }

    public function getMessage($fieldName)
    {
        return 'Error require with validate rule';
    }
}