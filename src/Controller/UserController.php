<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/user/list", name="userList")
     */
    public function list(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="userEdit", methods={"GET"})
     */
    public function edit(User $user): Response
    {
        $form = $this->createForm(UserEditType::class, $user);

        return $this->render('user/edit.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user
        ]);
    }


    /**
     * @Route("/user/edit/{id}", name="userEditPost", methods={"POST"})
     */
    public function editPost(User $user, Request $request): Response
    {
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $roles = [];
            if($request->get('roleWriterCB')) {
                $roles[] = 'ROLE_WRITER';
            }

            if($request->get('roleAdminCB')) {
                $roles[] = 'ROLE_ADMIN';
            }

            $user->setRoles($roles);

            

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/edit.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user
        ]);
    }
}
