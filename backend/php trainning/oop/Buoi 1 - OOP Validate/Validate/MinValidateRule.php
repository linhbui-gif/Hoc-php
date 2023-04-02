<?php
require_once __DIR__ . '/ValidateRule.php';
class MinValidateRule extends ValidateRule
{
    private $fieldValue;
    private $optional;

    public function __construct($fieldValue,$optional)
    {
        $this->fieldValue = $fieldValue;
        $this->optional = $optional;
    }

    public function passedValidate()
    {
        if (strlen($this->fieldValue) < $this->optional){
            return false;
        }
        return true;
    }

    public function getMessage()
    {
        return 'must be have min ' . $this->optional . ' character';
    }
}