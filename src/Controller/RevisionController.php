<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class RevisionController extends AbstractController
{
    /**
     * @Route("/revision", name="revision")
     */
    public function index(): Response
    {
        return $this->render('revision/index.html.twig', [
            'controller_name' => 'RevisionController',
        ]);
    }

    /**
     * @Route("/revision/presentation/{prenom}/{nom}", name="presentation")
     */
    public function presentation($prenom, $nom): Response
    {
        return new Response("Bonjour, je m'appelle $prenom $nom");
    }


    /**
     * @Route("/afficher/{nom}", name="afficherNom")
     */
    public function afficherNom($nom): Response
    {
        return $this->render('revision/afficher.html.twig', [ "nom" => $nom ]);
    }


    /**
     * @Route("/revision/createData", name="dataRevision")
     */
    public function dataRevision(): Response
    {
        $categorie1 = new Category();
        $categorie2= new Category();
        $categorie3 = new Category();

        $categorie1->setName("Littéraire");
        $categorie2->setName("Actualités");
        $categorie3->setName("Informatique");


        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie1);
        $em->persist($categorie2);
        $em->persist($categorie3);
        $em->flush();


        return new Response("Catégories créées");
    }
}
