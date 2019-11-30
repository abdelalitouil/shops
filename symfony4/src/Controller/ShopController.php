<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\DBALException;
use App\Repository\ShopRepository;
use App\Entity\Shop;
use App\Entity\DislikedShop;

/**
 * @Route("/shops")
 */
class ShopController extends AbstractController 
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /** 
     * Returns a list of shops sorted by distance with the actual location of the user
     * 
     * @Route("/", methods="GET")
     * @param ShopRepository $shopRepository
     * @return JsonResponse
     */
    public function shops(ShopRepository $shopRepository): JsonResponse 
    {
        $user = $this->getUser();

        // Delete disliked shop that exceed 2 hours
        try {
            $dislikedShops = $user->getDislikedShopObjects();
            foreach($dislikedShops as $dislikedShop) {
                if ($dislikedShop->isExpired()){
                    $this->em->remove($dislikedShop);
                    $this->em->flush();
                }                    
            }
        } catch (Exception $e) {
            throw $e;
        }

        $shops = $shopRepository->findShopsByUser($user);
        // Sort by distance
        ksort($shops);

        return new JsonResponse([
            'shops' => array_values($shops)
        ], Response::HTTP_OK);
    }

    /**
     * Add shop to the preferred list. 
     * 
     * @Route("/{id}/like", methods={"GET"})
     * @ParamConverter("shop", class="App\Entity\Shop")
     * @param Shop $shop
     * @return JsonResponse
    */
    public function like(Shop $shop): JsonResponse 
    {
        $user = $this->getUser();

        try {
            $user->addPreferredShop($shop);
            $this->em->persist($user);
            $this->em->flush();
       
        } catch (DBALException $e) {
            throw $e;
        }

        return new JsonResponse([
            'message' => "Added successfully to the preferred list."
        ], Response::HTTP_OK);
    }

    /**
     * Add shop to the disliked shop list
     *  
     * @Route("/{id}/dislike", methods="GET")
     * @ParamConverter("shop", class="App\Entity\Shop")
     * @param Shop $shop
     * @return JsonResponse
    */
    public function dislike(Shop $shop): JsonResponse 
    {
        $ds = new DislikedShop();
        $ds->setShop($shop);
        $ds->setTime(
            new \DateTime()
        );

        $user = $this->getUser();
        try {
            $user->addDislikedShop($ds);
            $this->em->persist($user);
            $this->em->flush();
        
        } catch (DBALException $e) {
            throw $e;
        }
        
        return new JsonResponse([
            'message' => "The shop will be hidden for 2 hours."
        ], Response::HTTP_OK);
    }
}