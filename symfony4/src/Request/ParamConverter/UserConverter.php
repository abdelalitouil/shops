<?php
namespace App\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;

class UserConverter implements ParamConverterInterface
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Convert request content from JSON to User object.
     *
     * @param Request $request
     * @param ParamConverter $configuration
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $user = new User();
        $user->setEmail($request->get('email'))
             ->setRoles([
                'ROLE_USER'
             ])
             ->setPassword(
                 $this->encoder->encodePassword(
                     $user,
                     $request->get('password')
                 )
             );
        
        $request->attributes->set(
            $configuration->getName(), 
            $user
        );
    }

    /**
     * Check if a param converter can convert the request into the required parameter.
     *
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration) : bool
    {
        return User::class === $configuration->getClass();
    }
}
