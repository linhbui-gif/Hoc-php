<?php

require __DIR__ . '/Validate/EmailValidateRule.php';
require __DIR__ . '/Validate/RequiredValidateRule.php';
require __DIR__ . '/Validate/MinValidateRule.php';
require __DIR__ . '/Validate/BetweenValidateRule.php';
require __DIR__ . '/Validate/RequireWithValidateRule.php';

class ValidateService {
    private $dataForm = [];
    private $rules = [];
    private $errors = [];
    private $ruleMapClass = [
        'required' => RequiredValidateRule::class,
        'email' => EmailValidateRule::class,
        'min' => MinValidateRule::class,
        'between' => BetweenValidateRule::class,
        'required_with' => RequireWithValidateRule::class,
    ];
    private $message;
    //keyword php solid
    public function __construct($dataForm,$rules)
    {
        $this->dataForm = $dataForm;
        $this->rules = $rules;
    }

    public function validate(){

        foreach($this->rules as $fieldName => $ruleString){
            $valueRule = $this->dataForm[$fieldName];
            $ruleArray = explode('|',$ruleString);
             foreach ($ruleArray as $ruleItem){

                 $ruleAndOptional = explode(':',$ruleItem);
                 $ruleName = $ruleAndOptional[0];
                 $optional = explode(',', end($ruleAndOptional));
                 $className = $this->ruleMapClass[$ruleName];
                 $classNameInstance = new $className(...$optional); // giống spread operator js
                if(!$classNameInstance->passedValidate($fieldName,$valueRule, $this->dataForm)){
                    $keyMessage = $fieldName. '.' . $ruleName;
                    $this->errors[$fieldName][] = $classNameInstance->getMessage($fieldName,$this->message[$keyMessage] ?? null);
                }
             }
        }
    }
    public function getErrors(){
        return $this->errors;
    }
    public function setMessage($message){
          $this->message = $message;
    }
}