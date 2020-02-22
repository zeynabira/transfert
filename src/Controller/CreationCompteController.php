<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Depot;
use App\Entity\Partenaire;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreationCompteController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route(
     *  name="creation_compte",
     *  path="api/creation_compte",
     *  methods={"POST"}
     * )
     */
    public function __invoke(Request $request)
    {
        // ...Recupération des données du partenaire par repo

        $json = json_decode($request->getContent(),false);

        $em = $this->getDoctrine()->getManager();

        $partenaire = new Partenaire();
        $partenaire->setNINEA($json->partenaire->NINEA);
        $partenaire->setNumRegistre($json->partenaire->NumRegistre);
        $partenaire->setAdress($json->partenaire->adress);
        $partenaire->setEmail($json->partenaire->email);
        $em->persist($partenaire);

        $role_id = $json->partenaire->users->role;
        $repo = $this->getDoctrine()->getRepository(Role::class);
        $role = $repo->find($role_id);

        $user = new User();
        $user->setUsername($json->partenaire->users->username);
        $user->setPartenaire($partenaire);
        $user->setRole($role);
        $user->setNomComplet($json->partenaire->users->nomComplet);
        $user->setRoles($json->partenaire->users->roles);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $json->partenaire->users->password));
        $em->persist($user);

        $depot = new Depot();
        $depot->setMontant($json->depots->montant);
        $depot->setUser($this->getUser());
        $em->persist($depot);

        $Compte = new Compte();
        $numero = time();
        $Compte->setNumCompte($numero);
        $Compte->setSolde($json->depots->montant);
        $Compte->setPartenaire($partenaire);

        $Compte->setUser($this->getUser());

        $Compte->addDepot($depot);

        $em->persist($Compte);

        //dd($Compte);

        $em->flush();

        return new JsonResponse($json);
    }
}
/**
 * {
 * "partenaire":{
*	  "NINEA": "6546465456",
*	  "NumRegistre": "RC-45615-2020",
*	  "adress": "rufisque",
*	  "email": "parenaire1@partenaire.sn",
*	  "users": {
*		  "username": "partenaire1",
*		  "roles": [
*		    "ROLE_PARTENAIRE"
*		  ],
*		  "nomComplet": "partenaire1",
*		  "role": 4,
*		  "password": "partenaire1"
*		}
*	},
* "depots":{
*	  "montant": 500000
*	  }
*}
 */