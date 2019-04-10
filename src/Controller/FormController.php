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
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request): Response
    {
        //récupération du formulaire qui est déja crée dans ArticleType
        $form = $this->createForm(ArticleType::class, $article);



        //on "remplit" le formulaire avec des données postées
        $form->handleRequest($request);

        //on vérifie si le formulaire est soumis et ses valeurs sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            //récupération de manager
            $entityManager = $this->getDoctrine()->getManager();

            //insertion de l'article dans la BDD
            $entityManager->flush(); //Exécution de SQL

            $this->addFlash('success', 'Votre article a bien été modifié !');
            //return $this->redirectToRoute('app_list');
            return $this->redirectToRoute('app_show', ['slug'=> $article->getSlug()
            ]);
        }

        //renvoi à la vue
        return $this->render(
            "article/update.html.twig",
            //on affiche le nouveau formulaire dans une vue Twig
            ['editForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/article/{slug}/suppression", name="article_delete")
     * @param Article $article
     * @return Response
     */
    public function delete(Article $article): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('app_list');
    }


}
