<?php

namespace App\Controller;

use App\Entity\EmailNewsletter;
use App\Form\EmailNewsletterType;
use App\Repository\EmailNewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;

/**
 * @Route("/email/newsletter")

 */
class EmailNewsletterController extends AbstractController
{
    /**
     * @Route("/", name="email_newsletter_index", methods={"GET"})
     *
     */
    public function index(EmailNewsletterRepository $emailNewsletterRepo): Response
    {
        return $this->render('email_newsletter/index.html.twig', [
            'email_newsletters' => $emailNewsletterRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="email_newsletter_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $date = new DateTime('NOW');

        $date->format('Y-m-d H:i:s');

        $emailNewsletter = new EmailNewsletter();
        $form = $this->createForm(EmailNewsletterType::class, $emailNewsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $emailNewsletter->setDate($date);
            $entityManager->persist($emailNewsletter);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations ! Vous êtes désormais inscrit à la newsletter.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('email_newsletter/new.html.twig', [
            'email_newsletter' => $emailNewsletter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_newsletter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailNewsletter $emailNewsletter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailNewsletter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailNewsletter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_newsletter_index');
    }
}
