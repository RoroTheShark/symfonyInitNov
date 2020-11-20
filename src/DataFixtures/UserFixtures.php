<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $roles = [
            'ROLE_WRITER',
            'ROLE_Admin',
        ];

        for($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setDateOfBirth($faker->dateTimeThisCentury())
                ->setPassword($this->encoder->encodePassword($user, 'toto'))
                ->setRoles($faker->randomElements($roles))
                ;

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setUsername('admin')
                ->setLastname('Aldaitz')
                ->setFirstname('Thomas')
                ->setDateOfBirth($faker->dateTimeThisCentury())
                ->setPassword($this->encoder->encodePassword($user, 'admin'))
                ->setRoles($roles)
                ;

        $manager->persist($admin);

        $manager->flush();
    }
}
