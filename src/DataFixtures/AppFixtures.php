<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {


        $user = new User("adminsyst");
        $user->setUsername("Zeyna");     
        $user->setNomComplet("Zeynab Sarr");
        $user->setPassword($this->encoder->encodePassword($user, "zeyna"));
        $user->setConfPwd("Zeyna");
        $user->setRoles(json_encode(array("ROLE_ADMIN")));
       
        // $product = new Product();
        // $manager->persist($product);
        
        $manager->persist($user);

        $manager->flush();
    }
}
