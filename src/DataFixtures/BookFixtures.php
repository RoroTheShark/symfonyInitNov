<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BookFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $titres = [
            'Les misérables',
            'Le comte de Monte-Cristo',
            '1Q84',
            'Beowulf',
            'Le seigneur des anneaux',
        ];

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 200; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence(6, true))
                    ->setResume($faker->paragraph(5, true))
                    ->setNbOfPages($faker->numberBetween(80, 2000))
                    ->setPublishedDate($faker->dateTimeThisCentury())
            ;

            $manager->persist($book);
        }
        
        $manager->flush();
    }
}
