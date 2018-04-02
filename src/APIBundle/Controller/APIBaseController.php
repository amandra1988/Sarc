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

    public function obtenerLatitudYLongitud($direccion){

        $data = array('status'=>false, 'latitud'=>0, 'longitud'=>0 );

        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($direccion).'&sensor=false');

        $respuesta = json_decode($geo, true);

        if ($respuesta['status'] == 'OK') {

            $data['status']   = true;
            $data['latitud']  = $respuesta['results'][0]['geometry']['location']['lat'];
            $data['longitud'] = $respuesta['results'][0]['geometry']['location']['lng'];
        }

        return $data;
    }
    
    public function obtenerCoordenadasGeograficas($coordenadasGPS){
        
        $latitud  = $coordenadasGPS['latitud'];
        $longitud = $coordenadasGPS['longitud'];
                
        $geotools    = new \League\Geotools\Geotools();
        $coordenadas = new \League\Geotools\Coordinate\Coordinate([$latitud, $longitud]);

        $coor = $geotools->convert($coordenadas);
        $coordenada = explode(" ",$coor->toUTM());

        $x = ($coordenada[1]/-9.99);
        $y = $coordenada[2];
        
        return [ 'x' =>$x, 'y' =>$y ] ;
    }
}