<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    public function list(): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);

        // Récupération de tous les articles
        $articles = $repository->findAll();

        // Renvoi des articles à la vue
        return $this->render('index.html.twig', [
            'articles' => $articles
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
