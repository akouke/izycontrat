<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email/paiement", name="paiement")
     */
    public function paiement()
    {
        return $this->render('email/payment_confirmation.html.twig');
    }

    /**
     * @Route("/email/order", name="order")
     */
    public function order()
    {
        return $this->render('email/order_confirmation.html.twig');
    }
}
