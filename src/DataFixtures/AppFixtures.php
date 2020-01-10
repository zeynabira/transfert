<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{    
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setLibelle("ADMIN_SYST"); 
        $manager->persist($role);
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
    }
}
