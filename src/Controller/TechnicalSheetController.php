<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fiche-izy-pratique/", name="technical_sheet")
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
     * @Route("sci", name="_sci")
     */
    public function sci()
    {
        return $this->render('technical_sheet/sci.html.twig');
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

    /**
     * @Route("micro-entreprise", name="_microBusiness")
     */
    public function microBusiness()
    {
        return $this->render('technical_sheet/micro_buisness.html.twig');
    }

    /**
     * @Route("entreprise-individuelle", name="_individualCompany")
     */
    public function individualCompany()
    {
        return $this->render('technical_sheet/individual_company.html.twig');
    }

    /**
     * @Route("sarl", name="_sarl")
     */
    public function sarl()
    {
        return $this->render('technical_sheet/sarl.html.twig');
    }
}
