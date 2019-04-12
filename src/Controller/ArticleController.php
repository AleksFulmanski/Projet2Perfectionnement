<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentFrontType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {

        $em    = $this->getDoctrine()->getManager();
        $dql   = "SELECT a FROM App\Entity\Article a";
        $query = $em->createQuery($dql);

        //$paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                9
            );/*limit per page*/

        return $this->render('index.html.twig', [
            'pagination' => $pagination

        ]);
    }



    /**
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function show(Article $article, Request $request): Response
    {
        //création du formulaire pour commentaires

        $newComment = new Comment(); //nouveau commentaire
        $newComment->setArticle($article); //on attache le commentaire à l'article

        $commentForm = $this->createForm(CommentFrontType::class, $newComment);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newComment);
            $entityManager->flush();

            $newComment = new Comment();
            $newComment->setArticle($article);
            $commentForm = $this->createForm(CommentFrontType::class, $newComment);

            // Récupération du Repository
            //$repository = $this->getDoctrine()
            //->getRepository(Article::class);

            // Récupération de tous les articles
            //$article = $repository->findOneBy(['slug' => $slug]);

            // Renvoi des articles à la vue
        }
        return $this->render('article/show.html.twig', ['article' => $article,
            'commentForm' => $commentForm->createView()
        ]);
    }
}
