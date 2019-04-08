<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        public function newForm(Request $request)
        {
            $article = new Article();
            $form = $this->createForm(ArticleType:: class, $article );


            return $this->render("article/form.html.twig", [
            'createForm' => $form->createView()
            ]);
        }
}
