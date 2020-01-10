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


        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $roles = $request->request->get('roles');
        $nom_complet = $request->request->get('nom_complet');
        $isActif = $request->request->get('isActif');
        $role = $request->request->get('role');
        
        if ($roles) {
            $roles =json_encode([]);
        
        }

        $user = new User();
        $user->setUsername("Zeyna");     
        $user->setNomComplet("Zeynab Sarr");
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setIsActif("true");
        $user->setRoles("ROLE_ADMIN");
       
        $manager->persist($user);
        $manager->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));

    }
}
