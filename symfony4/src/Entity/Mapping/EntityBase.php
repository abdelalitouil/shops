<?php

namespace App\Entity\Mapping;
use DateTime;

use Doctrine\ORM\Mapping as ORM;

class EntityBase implements EntityBaseInterface
{
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    public function getCreatedAt() :?DateTime
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt() :?DateTime
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void 
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void 
    {
        $this->setUpdatedAt(new DateTime());
    }
}
