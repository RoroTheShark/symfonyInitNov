<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

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

    /**
     * @Route("/user/register", name="userRegisterPost", methods={"POST"})
     */
    public function userCreatePost(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();

            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', [
            'userForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/user/register", name="userRegister", methods={"GET"})
     */
    public function userCreate() : Response
    {
        $form = $this->createForm(UserType::class);

        return $this->render('security/register.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

}
