<?php

namespace App\Controller;

use App\Entity\EmailNewsletter;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use \DateTime;

/**
 * @Route("/newsletter")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class NewsletterController extends AbstractController
{
    /**
     * @Route("/", name="newsletter_index", methods={"GET"})
     */
    public function index(NewsletterRepository $newsletterRepository): Response
    {
        return $this->render('newsletter/index.html.twig', [
            'newsletters' => $newsletterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creation", name="newsletter_new", methods={"GET","POST"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function new(
        Request $request,
        MailerInterface $mailer
    ): Response {

        $emailNewsletter = $this->getDoctrine()
            ->getRepository(EmailNewsletter::class)
            ->findAll();
        $mails = [];

        foreach ($emailNewsletter as $key) {
            $mails [] = $key->getEmail();
        }
        $date = new DateTime('NOW');

        $date->format('Y-m-d H:i:s');
        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $newsletter->setDate($date);
            $newsletter->setSubject($form->getData()->getSubject());
            $newsletter->setPost($form->getData()->getPost());
            $entityManager->persist($newsletter);
            $entityManager->flush();
            foreach ($mails as $mail) {
                $newsletterPost = $newsletter->getPost();
                $newslettersSub = $newsletter->getSubject();
                $email = (new Email())
                    ->from('contact@izy-contrat.fr')
                    ->to($mail)
                    ->subject($form->getData()->getSubject())
                    ->html(
                        $this->renderView('email/index.html.twig', [
                            'newsletterPost' => $newsletterPost,
                            'newsletterSub' => $newslettersSub

                        ])
                    );
                $mailer->send($email);
            }


            return $this->redirectToRoute('app_home');
        }

        return $this->render('newsletter/new.html.twig', [
            'newsletter' => $newsletter,
            'emailNewsletterRepo' => $emailNewsletter,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}", name="newsletter_show", methods={"GET"})
//     */
//    public function show(Newsletter $newsletter): Response
//    {
//        return $this->render('newsletter/show.html.twig', [
//            'newsletter' => $newsletter,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="newsletter_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Newsletter $newsletter): Response
//    {
//        $form = $this->createForm(NewsletterType::class, $newsletter);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('newsletter_index');
//        }
//
//        return $this->render('newsletter/edit.html.twig', [
//            'newsletter' => $newsletter,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="newsletter_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Newsletter $newsletter): Response
//    {
//        if ($this->isCsrfTokenValid('delete' . $newsletter->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($newsletter);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('newsletter_index');
//    }
}
