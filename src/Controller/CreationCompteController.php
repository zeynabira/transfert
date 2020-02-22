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

class CreationCompteController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, CompteRepository $Compte)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager =$entityManager;
        
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
        //$partenaireRepository = $this->entityManager->getRepository(Partenaire::class);
        
        //$request = new Request();
        $json = json_decode($request->getContent(),false);

        $partenaire = new Partenaire();
        $partenaire->setNINEA($json->partenaire->NINEA);
        $partenaire->setNumRegistre($json->partenaire->NumRegistre);
        $partenaire->setAdress($json->partenaire->adress);
        $partenaire->setEmail($json->partenaire->email);

        $role = new Role();

        $user = new User();
        $user->setUsername($json->partenaire->users->username);
        $user->setPartenaire($partenaire);
        $user->setRole($json->partenaire->users->role);
        $user->setNomComplet($json->partenaire->users->nomComplet);
        $user->setRoles($json->partenaire->users->roles);
        $user->setPassword($json->partenaire->users->password);

        $depot = new Depot();
        $depot->setMontant($json->depots->montant);

        $Compte = new Compte();
        $Compte->setNumCompte($json->NumCompte);
        $Compte->setSolde($json->Solde);
        $Compte->setPartenaire($partenaire);
        $Compte->setUser($user);
        $Compte->addDepot($depot);

        dd($Compte);
        return new JsonResponse($json);
    
    }
}
