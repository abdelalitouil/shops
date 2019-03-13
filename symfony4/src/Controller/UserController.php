<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Entity\User;

/**
 * @Route("/auth")
 */
class UserController extends AbstractController 
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Generate new secret key for user (Token).
     * 
     * @Route("/login", methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {       
        // Generate new token for user
        $token = bin2hex(random_bytes(90));
        
        $user = $this->getUser();
        $user->setToken($token)
             ->setLocation($request->get('location'));
        $this->em->persist($user);
        $this->em->flush();
        
        return new JsonResponse([
            'token' => $token
        ], Response::HTTP_OK);
    }
}
