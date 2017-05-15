<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // obtener el error de login si hay
        $error = $authenticationUtils->getLastAuthenticationError();
        // último nombre de usuario introducido por el usuario
        $lastUsername = $authenticationUtils->getLastUsername();        
        return $this->render(
            'AppBundle:login:index.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/secured/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/secured/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/secured/index", name="index")
     */
    public function dashboardAction()
    {
        $role=$this->getUser()->getRoles();
        switch ($role[0]){
            case 'ROLE_SUPERADMIN':
                return $this->redirectToRoute('superadmin-dashboard');
                break;
        }
    }

    public function tokenAction(Request $request){

        if(!$request->request->has('username')){
            throw $this->createAccessDeniedException();
        }
        $user=$this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy(array("username"=>$request->request->get('username')));
        if(!$this->get('security.password_encoder')->isPasswordValid($user, $request->request->get('password'))) {
            throw $this->createAccessDeniedException();
        }
        return new JsonResponse(['token' => $user->getToken()]);
    }

}
