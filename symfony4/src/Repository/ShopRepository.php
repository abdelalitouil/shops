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
                $dist = $this->distance(
                    (object) $user->getLocation(),
                    (object) $shop->getLocation()
                );
                $shopsArray[$dist] = $this->toArray($shop);
            }
        }
        return $shopsArray;
    }

    /**
     * Returns the preferred shops entities as a custom table.
     * 
     * @param User $user
     * @return array
     */
    public function getPreferredList($user): ?array
    {
        $shops = $user->getPreferredShops();
        $shopsArray = [];
        foreach ($shops as $shop){
            $shopsArray[] = $this->toArray($shop);
        }
        return $shopsArray;
    }

    /**
     * Calculate the distance between two points a and b
     * 
     * @param object $a
     * @param object $b
     * @return int
     */
    private function distance(object $a, object $b): int
    {
        if (($a->latitude == $b->latitude) && ($a->longitude == $b->longitude)) {
            return 0;
        } else {
            $theta = $a->longitude - $b->longitude;
            $dist = sin(deg2rad($a->latitude)) * sin(deg2rad($b->latitude)) +  cos(deg2rad($a->latitude)) * cos(deg2rad($b->latitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515 * 0.8684;

            return (int) $miles;
        }
    }
}
