<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/book/list", name="bookList")
     */
    public function list(BookRepository $bookRepository): Response
    {

        $books = $bookRepository->findAll();
        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }


    /**
     * @Route("/book/create", name="bookCreatePost", methods={"POST"})
     */
    public function createPost(Request $request): Response
    {
        $form = $this->createForm(BookType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $book = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Livre créé !');

            return $this->redirectToRoute('bookDetails', ['id' => $book->getId()]);
        }

        return $this->render('book/create.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/book/create", name="bookCreate", methods={"GET"})
     */
    public function create(): Response
    {
        $form = $this->createForm(BookType::class);

        return $this->render('book/create.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/book/{id}", name="bookDetails")
     */
    public function details(Book $book): Response
    {
        return $this->render('book/details.html.twig', [
            'book' => $book,
        ]);
    }


    



    /**
     * @Route("/data/bookcreates", name="dataCreationForBooks")
     */
    public function dataBooksCreate(): Response
    {
        $book1 = new Book();
        $book1->setTitle("Les Misérables")->setResume("Un livre sur des gens pauvres.")->setNbOfPages(800)->setPublishedDate(new DateTime("1887-04-06"));

        $book2 = new Book();
        $book2->setTitle("Le Horla")->setResume("Un livre qui froid dans le dos")->setNbOfPages(270)->setPublishedDate(new DateTime("1887-04-06"));


        $article1 = new Article();
        $article2 = new Article();
        $article3 = new Article();

        $article1->setTitle("Une critique du Horla ")->setBody("J'ai beaucoup aimé")->setAuthor("Thomas Aldaitz")->setDate(new DateTime());
        $article1->setBook($book2);
        $article2->setTitle("Quel mauvais Horla")->setBody("Je n'ai pas lu mais c'est pas bien")->setAuthor("Robert Test")->setDate(new DateTime());
        $article2->setBook($book2);
        $article3->setTitle("Vive les misérables")->setBody("Chef d'oeuvre de Victor Hugo, je le recommande chaudement")->setAuthor("Thomas Aldaitz")->setDate(new DateTime());
        $article3->setBook($book1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($book1);
        $em->persist($book2);
        $em->persist($article1);
        $em->persist($article2);
        $em->persist($article3);

        $em->flush();

        return new Response("Livres créés");
    }
}
