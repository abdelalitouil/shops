<?php

namespace App\Entity;

use App\Entity\Mapping\EntityBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends EntityBase implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Shop")
     */
    private $preferredShops;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $location = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DislikedShop", mappedBy="user", cascade={"persist"})
     */
    private $dislikedShops;

    public function __construct()
    {
        $this->preferredShops = new ArrayCollection();
        $this->dislikedShops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getPreferredShops(): Collection
    {
        return $this->preferredShops;
    }

    public function addPreferredShop(Shop $shop): self
    {
        if (!$this->preferredShops->contains($shop)) {
            $this->preferredShops[] = $shop;
        }

        return $this;
    }

    public function removePreferredShop(Shop $shop): self
    {
        if ($this->preferredShops->contains($shop)) {
            $this->preferredShops->removeElement($shop);
        }

        return $this;
    }

    public function getLocation(): ?array
    {
        return $this->location;
    }

    public function setLocation(?array $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getDislikedShops(): Collection
    {
        $shops = new ArrayCollection();
        foreach ($this->dislikedShops as $dislikedShop) {
            $shops[] = $dislikedShop->getShop();
        }
        return $shops;
    }

    /**
     * @return Collection|DislikedShop[]
     */
    public function getDislikedShopObjects(): Collection
    {
        return $this->dislikedShops;
    }

    public function addDislikedShop(DislikedShop $dislikedShop): self
    {
        if (!$this->dislikedShops->contains($dislikedShop)) {
            $this->dislikedShops[] = $dislikedShop;
            $dislikedShop->setUser($this);
        }

        return $this;
    }

    public function removeDislikedShop(DislikedShop $dislikedShop): self
    {
        if ($this->dislikedShops->contains($dislikedShop)) {
            $this->dislikedShops->removeElement($dislikedShop);
            // set the owning side to null (unless already changed)
            if ($dislikedShop->getUser() === $this) {
                $dislikedShop->setUser(null);
            }
        }

        return $this;
    }
}
