<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/mes-infos", name="mesInfos")
     * @isGranted("ROLE_USER")
     */
    public function mesInfos() : Response
    {
        return $this->render('security/mes-infos.html.twig');
    }


    /**
     * @Route("/user/dataCreate", name="userDataCreate")
     */
    public function dataCreate(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $em = $this->getDoctrine()->getManager();

        $users = $userRepository->findAll();

        foreach($users as $user) {
            $em->remove($user);
        }
        $em->flush();


        $user1 = new User();
        $user2 = new User();

        $user1->setUsername('writer')->setLastname('Aldaitz')->setFirstname('Thomas')
        ->setRoles(['ROLE_WRITER'])
        ->setPassword(
            $passwordEncoder->encodePassword($user1, 'writer')
        );

        $user2->setUsername('robert')->setLastname('Test')->setFirstname('Robert')
        ->setPassword($passwordEncoder->encodePassword($user2, 'robert'));


        
        $em->persist($user1);
        $em->persist($user2);
        $em->flush();

        return new Response("Utilisateurs créés.");
    }
}
