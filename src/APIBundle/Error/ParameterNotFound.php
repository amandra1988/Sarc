<?php

namespace APIBundle\Error;

/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:41
 */
class ParameterNotFound extends APIError{

    public function __construct($parameter) {
        parent::__construct(self::ERROR_CODE_ParameterNotFound, sprintf('parameter %s not found', $parameter));
    }
}