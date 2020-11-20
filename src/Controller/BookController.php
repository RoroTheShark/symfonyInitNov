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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @isGranted("ROLE_USER")
     */
    public function list(BookRepository $bookRepository): Response
    {

        $books = $bookRepository->findAllWithArticles();
        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }


    /**
     * @Route("/book/create", name="bookCreatePost", methods={"POST"})
     * @IsGranted("ROLE_WRITER")
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
     * @IsGranted("ROLE_WRITER")
     */
    public function create(): Response
    {
        $form = $this->createForm(BookType::class);

        return $this->render('book/create.html.twig', [
            'bookForm' => $form->createView(), 
            'presentation' => "Création d'un nouveau livre"
        ]);
    }


    /**
     * @Route("/book/edit/{id}", name="bookEditPost", methods={"POST"})
     */
    public function editPost(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('bookDetails', ['id' => $book->getId()]);
        }

        return $this->render('book/create.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/book/edit/{id}", name="bookEdit", methods={"GET"})
     */
    public function edit(Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);

        return $this->render('book/create.html.twig', [
            'bookForm' => $form->createView(),
            'presentation' => "Modification de " . $book->getTitle()
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
        $book2->setTitle("Le Horla")->setResume("Un livre qui froid dans le dos")->setNbOfPages(270);


        $em = $this->getDoctrine()->getManager();
        $em->persist($book1);

        dump($book2);

        $em->persist($book2);

        dump($book2);

        die();

        $em->flush();

        return new Response("Livres créés");
    }
}
