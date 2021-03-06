<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    /**
     * @Route("/cgu", name="cgu")
     */
    public function index() : Response
    {
        return $this->render('conditions/index.html.twig');
    }

    /**
     * @Route("/cgu/avocats", name="cgu_lawyer")
     */
    public function indexCguLawyer() : Response
    {
        return $this->render('conditions/lawyer.html.twig');
    }

    /**
     * @Route("/cgu/cgvu", name="cgu_cgvu")
     */
    public function indexCgvu() : Response
    {
        return $this->render('conditions/cgvu.html.twig');
    }
}
