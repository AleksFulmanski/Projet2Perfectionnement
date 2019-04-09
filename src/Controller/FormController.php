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

        //récupération du formulaire
        $article = new Article();
        $form = $this->createForm(ArticleType:: class, $article);

        //on "remplit" le formulaire avec des données postées
        $form->handleRequest($request);

        //on vérifie si le formulaire est soumis et ses valeurs sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            //récupération de manager
            $entityManager = $this->getDoctrine()->getManager();

            //insertion de l'article dans la BDD
            $entityManager->persist($article); //préparation de SQL
            $entityManager->flush(); //Exécution de SQL

            $this->addFlash('success', 'Votre article a bien été ajouté !');
            //return $this->redirectToRoute('app_list');
            return $this->redirectToRoute('app_show', ['slug'=> $article->getSlug()
            ]);
        }

        //on renvoie le formulaire à la vue
        return $this->render("article/form.html.twig", [
        'createForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}/edit", name="article_update")
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article): Response
    {
        var_dump($article);

        return $this->render("article/update.html.twig");
    }
}
