<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 10:47
 */

namespace APIBundle\Error;


class ObjectNotFound extends APIError
{
    public function __construct($content) {
        parent::__construct(self::ERROR_CODE_ObjectNotFound, sprintf('object %s not found', $content));
    }
}