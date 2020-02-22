<?php

namespace App\Entity;

use App\Entity\Partenaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;

/**
 * @ApiResource(
 *           collectionOperations={
 *                   "get",
 *                   "post"={"method"="post", "route_name"="creation_compte", "read"=true}
 *              },
 *              itemOperations={
 *                   "get",
 *                   "put",
 *                   "delete"
 *               }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NumCompte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Solde;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="Compte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="Compte")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="Comptes")
     */
    private $depots;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createAt;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->Solde = 0;
        $this->createAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?string
    {
        return $this->NumCompte;
    }

    public function setNumCompte(string $NumCompte): self
    {
        $this->NumCompte = $NumCompte;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->Solde;
    }

    public function setSolde(string $Solde): self
    {
        $this->Solde = $Solde;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setComptes($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getComptes() === $this) {
                $depot->setComptes(null);
            }
        }

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }
}
