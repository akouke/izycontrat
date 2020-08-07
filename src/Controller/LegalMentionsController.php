<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalMentionsController extends AbstractController
{
    /**
     * @Route("/mentions_legales", name="index_legals")
     */
    public function index() : Response
    {
        return $this->render('legal_mentions/index.html.twig');
    }
}
