<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CreateSasSasuController extends AbstractController
{
    /**
     * @Route("/create/sas", name="create_sas")
     */
    public function index()
    {
         return $this->render('create_entreprise/sas_sasu/sas_form.html.twig', [
            'typeStatut' => 'SAS',
        ]);
        // return $this->render('create_sas_sasu/index.html.twig', [
        //     'controller_name' => 'CreateSasSasuController',
        // ]);
    }
}
