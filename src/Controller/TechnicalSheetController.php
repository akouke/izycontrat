<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TechnicalSheetController extends AbstractController
{
    /**
     * @Route("/fiche/technique/sarl", name="technical_sheet")
     */
    public function index()
    {
        return $this->render('technical_sheet/index.html.twig');
    }
}
