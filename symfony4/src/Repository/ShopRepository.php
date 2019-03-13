<?php
namespace App\Repository;

use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ShopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * Convert Shop entity to an array.
     *
     * @param Shop $shop
     * @return array
     */
    public function toArray(Shop $shop): ?array
    {
        return [
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'location' => $shop->getLocation(),
            'image' => $shop->getImage(),
        ];
    }

    /**
     * Returns the shop entities as a table.
     *
     * @param User $user
     * @return array
     */
    public function getShops($user): ?array
    {
        $shops = $this->findAll();
        $preferredShops = $user->getPreferredShops();
        $dislikedShops = $user->getDislikedShops();

        $shopsArray = [];
        foreach ($shops as $shop){
            // Get all the shops except those who are in the preferred and disliked list
            if (!$preferredShops->contains($shop) && !$dislikedShops->contains($shop)){
                $shopsArray[] = $this->toArray($shop);
            }
        }
        return $shopsArray;
    }
}
