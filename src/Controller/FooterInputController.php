<?php

namespace App\Controller;

use App\Entity\EmailNewsletter;
use App\Form\EmailNewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooterInputController extends AbstractController
{

    public function input()
    {
        $emailNewsletter = new EmailNewsletter();
        $form = $this->createForm(EmailNewsletterType::class, $emailNewsletter, [
            'action' => $this->generateUrl('email_newsletter_new'),
            'method' => 'POST'
        ]);

        return $this->render('_footer.html.twig', [
            'email_newsletter' => $emailNewsletter,
            'form' => $form->createView(),
        ]);
    }
}
