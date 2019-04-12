<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditRoleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs", name="app_utilisateus")
     * @return Response
     */
    public function list(): Response
    {
        //recup repository
        $repo =$this->getDoctrine()->getRepository(User::class);
        //recup tous utilisateurs
        $users = $repo->findAll();
        //envoi à la vue
        return $this->render('user/list.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/back-office/utilisateurs/changement-roles/{id}", name="app_user_editrole", requirements={"id"="[0-9]+"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        //recuperation du formulaire

        $repo =$this->getDoctrine()->getRepository(User::class);

        $users = $repo->findOneBy(['id' => $id]);


        //instantiation du formulaire
        $form = $this->createForm(UserEditRoleType::class, $users);

        $form->handleRequest($request);

        //on vérifie si le formulaire est soumis et ses valeurs sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            //récupération de manager
            $entityManager = $this->getDoctrine()->getManager();

            //insertion de l'article dans la BDD
            $entityManager->flush(); //Exécution de SQL

            $this->addFlash('success', 'Le rôle a bien été modifié !');

        }

        return $this->render('user/edit.html.twig', ['user' => $users,
            'editForm' => $form->createView()]);
    }
}
