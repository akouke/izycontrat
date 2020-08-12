<?php


namespace App\Controller;

use App\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name = "email")
     */
    public function email(Request $request, MailerInterface $mailer):Response
    {
        $person = $this->getDoctrine()
            ->getRepository(Person::class)
            ->findAll();


        $email = (new Email())
            ->from("test@test.com")
            ->to('wild-circus@wild.com')
            ->subject('test')
            ->html($this->renderView('email/order_confirmation.html.twig', [
                'person' => $person
            ]));
        $mailer->send($email);
        return $this->redirectToRoute('home');
    }



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
