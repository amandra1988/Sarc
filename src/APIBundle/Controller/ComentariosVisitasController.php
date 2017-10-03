<?php

namespace APIBundle\Controller;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Ruta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ComentariosVisitasController extends APIBaseController
{
    /**
    * Obtener comentarios visitas del cliente
    * @return Response La respuesta serializada
    */ 
    public function getVisitasRutas(Request $request,Cliente $cliente, Ruta $ruta){
        dump('hOLA'); die;
    }

}