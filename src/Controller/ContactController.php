<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Swift\Mime\SimpleMessage;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/", name="app_contact")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param \Twig_environment $twig
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, \Swift_Mailer $mailer,environment $twig): Response
    {
        
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $body = $this->render('contact/email_contact.html.twig', [
            
            'contact' => $contact
            
            ]);

        if ($form->isSubmitted() && $form->isValid()) {
             $message = (new \Swift_Message())
                ->setFrom($contact->getEmail())
                ->setTo('contact@izy-contrat.fr')
                ->setSubject('Izy Contrat : Nouveau message du formulaire de contact')
                ->setBody($body, 'text/html');

            $mailer->send($message);
            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
