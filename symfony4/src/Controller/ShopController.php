<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\DBALException;
use App\Repository\ShopRepository;
use App\Entity\Shop;
use App\Entity\DislikedShop;

/**
 * @Route("api/shop")
 */
class ShopController extends AbstractController 
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /** 
     * Returns the list of shops sorted by distance
     * 
     * @Route("/list", methods="GET")
     * @param ShopRepository $shopRepository
     * @return JsonResponse
     */
    public function list(ShopRepository $shopRepository): JsonResponse 
    {
        $user = $this->getUser();

        // Delete DislikedShop objects that exceeds 2h
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

        $shops = $shopRepository->getShops($user);
        // Sort by distance
        ksort($shops);

        return new JsonResponse([
            'shops' => $shops
        ], Response::HTTP_OK);
    }

    /**
     * Returns the list of preferred shops
     * 
     * @Route("/preferredList", methods="GET")
     * @param ShopRepository $shopRepository
     * @return JsonResponse
     */
    public function preferredList(ShopRepository $shopRepository): JsonResponse
    {
        $user = $this->getUser();
        $shops = $shopRepository->getPreferredList($user);

        return new JsonResponse([
            'shops' => $shops
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
            'message' => "Added successfully to preferred shops list."
        ], Response::HTTP_OK);
    }
}