<?php


namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiArticleController extends AbstractController
{
    /**
     * @Route("/api/article/likes/{slug}")
     * @param $slug
     * @return JsonResponse
     */
    public function incrementLikes($slug): JsonResponse
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->findOneBy(['slug' => $slug]);

        $likes = $article->getLikes() + 1;
        $article->setLikes($likes);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->json([
            'cpt' => $likes
        ]);
    }
}
