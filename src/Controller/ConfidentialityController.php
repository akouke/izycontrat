<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfidentialityController extends AbstractController
{
    /**
     * @Route("/confidentialite", name="confidential")
     */
    public function index() : Response
    {
        return $this->render('confidential/index.html.twig');
    }
}
