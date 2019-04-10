<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs")
     * @return Response
     */
    public function list(): Response
    {
        $repo =$this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        return $this->render('user/list.html.twig', ['users' => $users]);
    }
}
