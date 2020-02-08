<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /**
     * @Route("/login_check", name="auth")
     */
    public function registre(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $manager = $this->getDoctrine()->getManager();


        $user = $request->request->get('username');
        $user = $request->request->get('password');
        $roles = $request->request->get('roles');
        $user = $request->request->get('nom_complet');
        $user = $request->request->get('isActif');
        $role = $request->request->get('role');
        
        if ($roles) {
            $roles =json_encode([]);
        
        }

        $user = new User();
        $user->setUsername("Zeyna");     
        $user->setNomComplet("Zeynab Sarr");
        $user->setPassword($this->encoder->encodePassword($user, "zeyna"));
        $user->setRole($role
    );
        $user->setIsActif(true);
        $user->setRoles(array("ROLE_".$role->getLibelle()));
       
        $manager->persist($user);
        $manager->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));

    }
}
