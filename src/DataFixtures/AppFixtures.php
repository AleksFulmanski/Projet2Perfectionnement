<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i<50; $i++) {
            $article = new Article();
            $article->setTitle('Titre de l\'article');
            $article->setContent('Contenu de l\'article');
            $article->setIsPublished(true);

            $manager->persist($article);

            $comment = new Comment();
            $comment->setContent('Contenu du commentaire');
            $comment->setArticle($article);

            $manager->persist($comment);
        }


        $manager->flush();
    }
}
