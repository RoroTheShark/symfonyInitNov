<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about/{value}", name="about")
     */
    public function about(Request $request, $value): Response
    {
        $session = $request->getSession();

        if($value == 'stop') {
            $session->clear();
            $cumul = [];
        } else {
            $cumul = $session->get('cumul', []);
            $cumul[] = $value;
            $session->set('cumul', $cumul);
        }

        return $this->render('about/about.html.twig', [
            'values' => $cumul
        ]);
    }
}
