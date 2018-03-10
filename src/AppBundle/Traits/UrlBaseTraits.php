<?php

namespace AppBundle\Traits;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait UrlsBaseTrait
 * Contiene funciones para
 * @package WcmBundle\Traits
 */
trait UrlBaseTraits
{

    /**
     * Devuelve una Url base según el tipo de parámetro pasado
     * @param string $tipo El parámetro de donde obtener la url base. Parámetros soportados:
     * [base, api, img, partials]
     * @param string $categoria La categoria en la que está anidada el proyecto de angular. Ej:
     * evaluaciones, encuestas, etc.
     * @uses ReflectionClass Para obtener el nombre del controlador
     * @return string La url base solicitada
     * @throws InvalidArgumentException Si no se provee un tipo válido
     */
    public function getUrlBase($tipo,$perfil = null)
    {
        if($this instanceof Controller) {
            /** Se obtiene el nombre sin namespace del controlador */
            $reflectionClass = new ReflectionClass($this);
            $nombre = str_replace('Controller', '', $reflectionClass->getShortName());

            /** @var Request $request */
            $request = $this->container->get('request_stack')->getMasterRequest();
            $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
            $archivoEntorno = '';
            if(in_array($this->get('kernel')->getEnvironment(), ['dev', 'test'])) {
                $archivoEntorno = '/app_' . $this->get('kernel')->getEnvironment() . '.php';
            }

            switch ($tipo) {
                case "base":
                    $url = $baseUrl . $archivoEntorno;
                    break;
                case "api":
                    $url = $baseUrl . $archivoEntorno . '/api/1';
                    break;
                case "img":
                    $url = $baseUrl . '/assets/img';
                    break;
                case "templates":
                    $url = $baseUrl . "/assets/angular/proyecto/".$perfil."/".$tipo;
                    break;
                default:
                    throw new InvalidArgumentException();
            }
            return $url . '/';
        }
        return '';
    }

}