<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }

    public function blog(): Response
    {
        return $this->render('blog.html.twig');
    }
}
