<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private $bookRepo;
    private $userRepo;

    public function __construct(BookRepository $bookRepository, UserRepository $userRepository)
    {
        $this->bookRepo = $bookRepository;
        $this->userRepo = $userRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $books = $this->bookRepo->findAll();
        $users = $this->userRepo->findAll();

        for($i = 0; $i < 1000; $i++) {

            $author = $faker->randomElement($users);

            $article = new Article();
            $article->setTitle($faker->sentence(8, true))
                    ->setBody($faker->text(500))
                    ->setDate($faker->dateTimeThisDecade())
                    ->setBook($faker->randomElement($books))
                    ->setUser($author)
                    ->setAuthor($author->getFullname())
                    ;
            $manager->persist($article);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            BookFixtures::class,
            UserFixtures::class
        ];
    }
}
