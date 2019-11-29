<?php
namespace App\Entity\Mapping;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

interface EntityBaseInterface
{    
    /**
     * Get createdAt
     *
     * @return null|DateTime
     */
    public function getCreatedAt(): ?DateTime;
    
    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt);
        
    /**
     * Get updatedAt
     *
     * @return self
     */
    public function getUpdatedAt(): ?DateTime;
    
    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void;
    
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void;
}
