<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 31-03-17
 * Time: 15:14
 */

namespace APIBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UsersController extends APIBaseController
{
    /**
     * @ParamConverter("user", class="AppBundle:User", options={"id" = "user"})
     */
    public function getUsersAction(User $user,Request $request ){
        $user=$this->getRepoUser()->find($user);
        return $this->serializedResponse($user, ['user_detail']);
    }

}