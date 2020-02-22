<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *              collectionOperations={
 *                   "get"={"security"="is_granted('ROLE_ADMIN')"},
 *                   "post"={"security"="is_granted('ROLE_ADMIN')"}
 *              },
 *              itemOperations={
 *                   "get"={"security"="is_granted('USER_VIEW',object)"},
 *                   "put"={"security"="is_granted('USER_EDIT',object)"},
 *                   "delete"={"security"="is_granted('ROLE_ADMIN_SYST')"}
 *               },
 *              normalizationContext = {"groups" = {"user:read"}},
 *              denormalizationContext = {"groups" = {"user:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read","user:write"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read","user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write"})
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:read"})
     */
    private $isActif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read","user:write"})
     * @ApiSubresource()
     */
    private $role;

    /**
     * @SerializedName("password")
     * @Groups({"user:write"})
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="user")
     */
    private $Depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="user")
     */
    private $Comptes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     */
    private $partenaire;

    public function __construct()
    {
        $this->isActif = true;
        $this->Depots = new ArrayCollection();
        $this->Comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
       
        return array_unique($roles);
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|Depots[]
     */
    public function getDepots(): Collection
    {
        return $this->Depots;
    }

    public function addDepots(Depot $depots): self
    {
        if (!$this->Depots->contains($depots)) {
            $this->Depots[] = $depots;
            $depots->setUser($this);
        }

        return $this;
    }

    public function removeDepots(Depot $depots): self
    {
        if ($this->Depots->contains($depots)) {
            $this->Depots->removeElement($depots);
            // set the owning side to null (unless already changed)
            if ($depots->getUser() === $this) {
                $depots->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comptes[]
     */
    public function getComptes(): Collection
    {
        return $this->Comptes;
    }

    public function addComptes(Compte $comptes): self
    {
        if (!$this->Comptes->contains($comptes)) {
            $this->Comptes[] = $comptes;
            $comptes->setUser($this);
        }

        return $this;
    }

    public function removeComptes(Compte $comptes): self
    {
        if ($this->Comptes->contains($comptes)) {
            $this->Comptes->removeElement($comptes);
            // set the owning side to null (unless already changed)
            if ($comptes->getUser() === $this) {
                $comptes->setUser(null);
            }
        }

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
}
