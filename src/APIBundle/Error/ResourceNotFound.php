<?php
namespace APIBundle\Error;
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:41
 */
class ResourceNotFound extends APIError{

    public function __construct($resource) {
        parent::__construct(self::ERROR_CODE_ResourceNotFound, sprintf('resource %s not found', $resource));
    }
}