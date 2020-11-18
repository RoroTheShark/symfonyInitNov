<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/page-contact", name="contact")
     */
    public function contact(): Response
    {
        $email = "robert@dawan.fr";
        return $this->render("home/contact.html.twig", ["email" => $email]);
    }


    /**
     * @Route("/home/bonjour/{chiffre}", name="bonjourRepet", requirements={"chiffre"="\d+"})
     */
    public function bonjourRepet(int $chiffre): Response
    {
        $contenu = "";

        for($i = 0; $i < $chiffre; $i++) {
            $contenu .= "Bonjour !<br>";
        }
        return new Response($contenu);
    }


    /**
     * @Route("/home/bonjour/{name}", name="bonjour")
     */
    public function bonjour($name): Response
    {
        return new Response("Bonjour $name !");
    }


    /**
     * @Route("/addition/{chiffre1}/{chiffre2}", name="additionSomme", requirements={"chiffre1"="\d+", "chiffre2"="\d+"})
     */ 
    public function additionChiffres($chiffre1, $chiffre2): Response
    {
        return new Response('le resultat est ' . ($chiffre1 + $chiffre2));
    }

    /**
     * @Route("/addition/{nom1}/{nom2}", name="additionCouple")
     */
    public function additionCouple($nom1, $nom2): Response
    {
        return new Response("$nom1 et $nom2 sont en couple.");
    }

    /**
     * @Route("/multiplication/{chiffre1}&{chiffre2}", name="mutliplication")
     */
    public function multiplication($chiffre1, $chiffre2): Response
    {
        return new Response('le resultat est ' . ($chiffre1 * $chiffre2));
    }

    /**
     * @Route("/Auteur/nom/{nom}/prenom/{prenom}", name="auteur")
     */
    public function auteur($prenom, $nom): Response
    {
        return new Response("L'auteur est $prenom $nom");
    }


    /**
     * @Route("/passageGet", name="paramGet")
     */
    public function paramGet(Request $request): Response
    {
        $value = $request->get("param");
        return new Response("La valeur passée en paramètre est $value");
    }

    /**
     * @Route("/inscription/newsletter/{nomNewsletter}", name="inscriptionNewsletter")
     */
    public function inscription(Request $request, $nomNewsletter) : Response
    {
        $email = $request->get('email');
        return new Response("$email s'est inscrit à la news $nomNewsletter");
    }

    /**
     * @Route("/Auteur", name="auteurRaccourci")
     */
    public function shortAuteur(): Response
    {
        return $this->redirectToRoute('auteur', ['nom' => 'Hugo', 'prenom' => 'Victor']);
        //return $this->forward(HomeController::class . "::auteur",['nom' => 'Hugo', 'prenom' => 'Victor']);
    }



    /**
     * @Route("/division/{chiffre1}/{chiffre2}", name="division", requirements={"chiffre2"="^[1-9][0-9]*$"})
     */
    public function division($chiffre1, $chiffre2): Response
    {
        return new Response('le resultat est ' . ($chiffre1 / $chiffre2));
    }
}
