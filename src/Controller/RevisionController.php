<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
