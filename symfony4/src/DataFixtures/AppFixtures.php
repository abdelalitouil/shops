<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use App\Entity\Shop;
use App\Entity\User;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Create a Faker\Generator instance to generate fake data
        $faker = Factory::create();

        // Create 12 shops: name, location and image
        for ($i = 0; $i < 12; $i++) {
            $shop = new shop();
            $location = [
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude()
            ];
            $shop->setName($faker->company)
                 ->setLocation($location)
                 ->setImage($faker->imageUrl(200, 200, 'city'));
            $manager->persist($shop);
        }

        // Create default user
        $user = new User();
        $user->setEmail('demo@unitedremote.com');
        // Encode the plain password
        $user->setPassword(
            $this->encoder->encodePassword(
                $user, 
                'demo'
            )
        );
        // Assign user role to the user account
        $user->setRoles([
            'ROLE_USER'
        ]);
        $manager->persist($user);
        
        $manager->flush();
    }
}
