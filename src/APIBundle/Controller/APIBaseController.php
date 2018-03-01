<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 29-03-17
 * Time: 9:56
 */
namespace APIBundle\Controller;
use JMS\Serializer\SerializationContext;

use Symfony\Component\HttpFoundation\Response;

class APIBaseController extends \AppBundle\Controller\BaseController
{
    public function serializedResponse($data, $groups = null, $codigoEstado = 200){
        $serializer = $this->container->get('jms_serializer');
        if(is_array($groups)){
            $response = new Response($serializer->serialize($data, 'json', SerializationContext::create()->setGroups($groups)), $codigoEstado);
        }else{
            $response = new Response($serializer->serialize($data, 'json'), $codigoEstado);
        }
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function returnError(\APIBundle\Error\APIError $error){

        $serializer = $this->container->get('jms_serializer');
        $response = new Response($serializer->serialize(array('error'=>$error->getMessage(), 'code'=>$error->getCode()), 'json'));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(500);
        return $response;
    }
}