<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleAutoUserType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\BookRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/list", name="articleList")
     */
    public function list(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/critics/list", name="criticsList")
     */
    public function critics(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findCritics();

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/details/{id}", name="articleDetails")
     */
    public function details(Article $article): Response
    {

        return $this->render('article/details.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * @Route("/article/create", name="articleCreate", methods={"GET"})
     */
    public function create(Request $request, BookRepository $bookRepository): Response
    {
        $article = new Article();
        $type = ArticleType::class;
        
        if($user = $this->getUser()) {
            $type = ArticleAutoUserType::class;
            $article->setAuthor($user->getFullname());
        }

        
        if($bookId = $request->get('bookId')) {
            $book = $bookRepository->find($bookId);
            $article->setBook($book);
        }
        

        $form = $this->createForm($type, $article);

        return $this->render('article/create.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/create", name="articleCreatePost", methods={"POST"})
     */
    public function createPost(Request $request): Response
    {
        $type = ArticleType::class;
        if($this->getUser())
            $type = ArticleAutoUserType::class;

        $form = $this->createForm($type);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();

            if($user = $this->getUser()) {
                $article->setUser($user);
                $article->setAuthor($user->getFullname());
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("articleList");

        }

        return $this->render('article/create.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/article/edit/{id}", name="articleEdit", methods={"GET"})
     */
    public function edit(Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('article/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/article/edit/{id}", name="articleEditPost", methods={"POST"})
     */
    public function editPost(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', "L'article a bien été modifié !");

            return $this->redirectToRoute("articleList");

        }

        return $this->render('article/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/mes-articles", name="mesArticles")
     * @isGranted("ROLE_USER")
     */
    public function mesArticles(): Response
    {
        $user = $this->getUser();
        $articles = $user->getArticles();

        return $this->render('article/mes_articles.html.twig', [
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/data/create", name="dataCreation")
     */
    public function dataCreation(): Response
    {
        /*
        $article = new Article();
        $article->setTitle("1er article")
                ->setBody("Eiusmod duis proident nostrud aliqua irure reprehenderit excepteur elit aliquip occaecat. Commodo ut veniam eiusmod ullamco proident duis proident voluptate eiusmod. Exercitation qui incididunt non cillum mollit cupidatat adipisicing tempor enim est duis in veniam in. Reprehenderit officia dolor ut officia irure exercitation officia esse est commodo nulla nisi labore. Sit consectetur consectetur et reprehenderit laborum ea aute elit proident ut magna.
                            Laboris cillum irure anim id. Nulla deserunt duis sunt ipsum nulla eu ea nulla. Veniam fugiat adipisicing pariatur fugiat adipisicing cillum sit in ullamco magna. Qui velit aute veniam est duis. Minim duis aliquip nostrud consequat labore exercitation consequat.")
                ->setAuthor("Thomas Aldaitz")            
                ->setDate(new DateTime());
                */
                
        $article2 = new Article();
        $article2->setTitle("Article 2")
                ->setBody("Velit commodo eiusmod id amet qui qui ullamco. Aliquip non ullamco commodo excepteur est enim commodo. Labore nostrud est velit cupidatat consequat. Nisi laboris commodo et nisi.

Tempor Lorem nostrud quis duis dolore exercitation cillum pariatur velit. Esse laborum incididunt excepteur quis aliqua culpa et fugiat exercitation. Anim exercitation elit minim dolor non adipisicing exercitation minim aute non in magna consectetur.

Incididunt ad quis amet minim eu eu consectetur incididunt fugiat. In nisi in anim laboris ea. Magna id eu irure sint anim excepteur occaecat tempor qui nisi irure elit minim eiusmod. In ea ullamco sit laboris laboris dolore excepteur occaecat elit ad Lorem laboris nisi. Reprehenderit in ex sit sunt irure commodo labore labore nostrud amet. Dolor excepteur sint veniam adipisicing ad consectetur tempor ut officia.")
                ->setAuthor("Thomas Aldaitz")            
                ->setDate(new DateTime());

        $article3 = new Article();
        $article3->setTitle("Article 3")
                ->setBody("Le terme « hamster » est un emprunt à l'allemand Hamster, en vieux haut-allemand hamustro (le verbe allemand hamstern « faire des réserves », est dérivé du nom et non l'inverse). Le nom allemand est lui-même emprunté au slave, cf. slavon russe khoměstorǔ1. Le russe khomiak (« hamster »), ancien khoměkǔ, semble être une forme abrégée de khoměstorǔ. On a proposé d'expliquer le slave khoměstorǔ comme un emprunt à l'avestique hamaēstar (« ennemi qui jette à terre ») (pour le sens, comparer chor yrlak « hamster », yr- « être ennemi de » ; en effet, le hamster plie les tiges des céréales pour en manger les grains)2. Le lituanien staras3 « spermophile (lt) » est inséparable du mot slave, mais la relation est incertaine (il pourrait en être une autre forme courte, ou alors contredire l'étymologie iranienne).")
                ->setAuthor("Thomas Aldaitz")            
                ->setDate(new DateTime());

        $article4 = new Article();
        $article4->setTitle("Article 4")
                ->setBody("Les cricétidés sont différenciés physiquement par une queue très épaisse et courte (moins de 45 % de la longueur du corps), un corps compact, des pattes courtes et larges, des oreilles petites et velues, un estomac comportant deux compartiments, des particularités dentaires avec une formule dentaire 1/1, 0/0, 0/0, 3/3 = 16, des spécificités génétiques, etc. Leur taille est très variable selon les espèces avec un corps de 5 à 34 cm et une queue de 0,7 à 10,6 cm8.")
                ->setAuthor("Robert Test")            
                ->setDate(new DateTime());

        $article5 = new Article();
        $article5->setTitle("Article 5")
                ->setBody("Les hamsters sont polygames, c'est-à-dire que les mâles et les femelles n'ont pas de partenaire précis. À la saison des amours les mâles hamsters vont d'un terrier à l'autre à la recherche de femelles réceptives. Un opercule empêche la fécondation des œufs par les mâles suivants et la femelle chasse alors le plus souvent les prétendants de son territoire. La saison de reproduction se situe entre février et novembre. Les femelles auront deux à trois portées par an après une courte gestation de 15 à 22 jours. Le nombre de petits par portée est très variable, pouvant aller jusqu'à 13, avec une moyenne de 5 à 7 petits. Les petits sont allaités 3 semaines environ et deviennent adultes à 6 ou 8 semaines8.")
                ->setAuthor("Robert Test")            
                ->setDate(new DateTime());
                        
                
        $entityManager = $this->getDoctrine()->getManager(); // recupérer l'outil fournit par Doctrine
        $entityManager->persist($article2); // designe $article pour le mettre en mémoire dans Doctrine       
        $entityManager->persist($article3); 
        $entityManager->persist($article4); 
        $entityManager->persist($article5); 
        $entityManager->flush(); // On demande à Doctrine de mettre en BDD tout ce qu'il a en mémoire

        return new Response("Données Créées");
    }
}
