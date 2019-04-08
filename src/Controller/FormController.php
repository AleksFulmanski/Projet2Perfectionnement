<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    /*
    public function index()
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }*/
    /**
     * @Route("/article", name="newForm", methods={"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newForm(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType:: class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Votre article a bien été ajouté !');
            return $this->redirectToRoute('app_list');
        }


        return $this->render("article/form.html.twig", [
        'createForm' => $form->createView()
        ]);
    }
}
