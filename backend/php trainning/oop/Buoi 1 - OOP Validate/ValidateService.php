<?php

require __DIR__ . '/Validate/EmailValidateRule.php';
require __DIR__ . '/Validate/RequiredValidateRule.php';
require __DIR__ . '/Validate/MinValidateRule.php';

class ValidateService {
    private $dataForm = [];
    private $rules = [];
    private $errors = [];
    //keyword php solid
    public function __construct($dataForm,$rules)
    {
        $this->dataForm = $dataForm;
        $this->rules = $rules;
    }

    public function validate(){
        foreach ($this->rules as $field => $rule){
            $fieldValue = $this->dataForm[$field];
            if(strpos($rule, "|")){
                $ruleArray = explode("|", $rule);
                foreach($ruleArray as $ruleItem){
                    $this->addErrorByInstance($ruleItem,$fieldValue, $field);
                }
            } else {
                $this->addErrorByInstance($rule,$fieldValue, $field);
            }
        }
    }
    public function maxValidate($valueRule, $fieldName, $optional){
        if (strlen($valueRule) > $optional){
            $this->errors[$fieldName][] = $fieldName . " " . 'must be have max ' . $optional . ' character';
        }
    }
    public function getErrors(){
        return $this->errors;
    }
    private function addErrorByInstance($ruleItem, $fieldValue, $field){
        if(strpos($ruleItem,":")){
            $ruleOptional = explode(':', $ruleItem);
            $functionValidate = ucfirst($ruleOptional[0]) . 'ValidateRule';
            $instance = new $functionValidate($fieldValue, $ruleOptional[1]);
            if (!$instance->passedValidate()){
                $message = $field . " " . $instance->getMessage();
                $this->errors[$field][] = $message;
            }
        } else {
            $classNameValidate = ucfirst($ruleItem) . 'ValidateRule';
            $instance = new $classNameValidate($fieldValue);
            if (!$instance->passedValidate()){
                $message = $field . " " . $instance->getMessage();
                $this->errors[$field][] = $message;
            }
        }

    }
    public function countErrors() {
        if(is_array($this->errors) && count($this->errors) > 0){
            return true;
        }
        return false;
    }
}