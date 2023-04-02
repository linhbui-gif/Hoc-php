<?php
class ValidateServicesVerion01 {
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
            //cach lam 1
           $valueRule = $this->dataForm[$field];
           if(strpos($rule,"|")){
               $ruleArray = explode("|", $rule);
               foreach($ruleArray as $ruleItem){
                   //Check rule has : optional
                   if(strpos($ruleItem,":")){
                        $ruleOptional = explode(':', $ruleItem);
                        $functionValidate = $ruleOptional[0] . 'ValidateRule';
                        $this->$functionValidate($valueRule, $field, $ruleOptional[1]);
                    } else{
                        $functionValidate = $ruleItem . 'ValidateRule';
                        //function validate dynamic
                        $this->$functionValidate($valueRule, $field);
                    }
               }
           } else {
                $functionValidate = $rule . 'ValidateRule';
                //function validate dynamic
                $this->$functionValidate($valueRule, $field);
           }
        }
    } function requiredValidate($valueRule, $fieldName){
        if(!$valueRule){
            $this->errors[$fieldName][] = $fieldName . " " . 'not Empty';
        }
    }
    public function emailValidate($valueRule, $fieldName){
        if (!filter_var($valueRule, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$fieldName][] = $fieldName . " " . 'is not valid email.';
        }
    }
    public function minValidate($valueRule, $fieldName, $optional){
        if (strlen($valueRule) < $optional){
            $this->errors[$fieldName][] = $fieldName . " " . 'must be have min ' . $optional . ' character';
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
    public function countErrors() {
        if(is_array($this->errors) && count($this->errors) > 0){
            return true;
        }
        return false;
    }
}