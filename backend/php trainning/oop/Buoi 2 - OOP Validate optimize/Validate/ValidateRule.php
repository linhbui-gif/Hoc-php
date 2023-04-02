<?php
abstract class ValidateRule {
    abstract public function passedValidate($fieldName,$valueRule);
    abstract public function getMessage($fieldName,$message);
}