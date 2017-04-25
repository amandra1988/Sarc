<?php
namespace APIBundle\Error;
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:39
 */

class ContentNotAllowed extends APIError{

    public function __construct($content) {
        parent::__construct(self::ERROR_CODE_ContentNotAllowed, sprintf('content %s is not allowed', $content));
    }
}