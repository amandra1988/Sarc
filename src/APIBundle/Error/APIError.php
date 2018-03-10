<?php
namespace APIBundle\Error;
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:37
 */
class APIError {

    CONST ERROR_CODE_ParameterNotFound = 100;
    CONST ERROR_CODE_ResourceNotFound = 101;
    CONST ERROR_CODE_ContentNotAllowed = 102;
    CONST ERROR_CODE_ActionNotAllowed = 103;
    CONST ERROR_CODE_ObjectNotFound = 104;

    private $code;
    private $message;

    public function __construct($code, $message) {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(){
        return $this->code;
    }

    public function getMessage(){
        return $this->message;
    }
}
