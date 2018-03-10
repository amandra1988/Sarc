<?php
namespace APIBundle\Error;
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:38
 */
class ActionNotAllowed extends APIError{

    public function __construct($action) {
        parent::__construct(self::ERROR_CODE_ActionNotAllowed, sprintf('action %s is not allowed', $action));
    }
}