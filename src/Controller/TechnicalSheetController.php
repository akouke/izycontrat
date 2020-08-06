<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/fiche/izy/pratique/", name="technical_sheet")
 */
class TechnicalSheetController extends AbstractController
{
    /**
     * @Route("sasu", name="_sasu")
     */
    public function sasu()
    {
        return $this->render('technical_sheet/sasu.html.twig');
    }

    /**
     * @Route("sas", name="_sas")
     */
    public function sas()
    {
        return $this->render('technical_sheet/sas.html.twig');
    }

    /**
     * @Route("eurl", name="_eurl")
     */
    public function eurl()
    {
        return $this->render('technical_sheet/eurl.html.twig');
    }

}
