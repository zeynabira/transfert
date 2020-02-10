<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserDataPersister implements DataPersisterInterface{

    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof User;
    }
    public function persist($data)
    {
        // TODO: Implement persist() method.
    }
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}