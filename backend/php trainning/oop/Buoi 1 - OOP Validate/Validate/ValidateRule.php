<?php
abstract class ValidateRule {
    abstract public function passedValidate();
    abstract public function getMessage();
}