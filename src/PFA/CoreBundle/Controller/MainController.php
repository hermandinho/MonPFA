<?php
/**
 * Created by PhpStorm.
 * User: Herman
 * Date: 16/05/2016
 * Time: 11:55
 */

namespace PFA\CoreBundle\Controller;


use PFA\CoreBundle\Entity\Project;
use PFA\CoreBundle\Entity\ProjectMember;
use PFA\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MainController extends Controller
{

    protected function getThisUser()
    {
        $tokenStorage = $this->container->get('security.token_storage');

        if ($tokenStorage->getToken()->getUser() == 'anon.')
            throw new AccessDeniedException('You should be signed in');
        /** @var User $user */
        $user = $tokenStorage->getToken()->getUser();
        return $user;
    }

    protected function getSerializer(){
        return $this->get('jms_serializer');
    }

    protected function getEM()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function isProjectMember(User $user, Project $project)
    {
        $projectMembers = $this->get("pfa_core.services.project_manager")->getProjetMembers($project);
        $is = false;

        /** @var ProjectMember $member */
        foreach ($projectMembers as $member) {
            if($member->getMemeber()->getId() == $this->getThisUser()->getId()){
                $is = true;
                break;
            }
        }
        return $is;
    }
}