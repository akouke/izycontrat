<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\User;
use App\Form\UploadType;
use App\Repository\UploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/upload")
 */
class UploadController extends AbstractController
{
    /**
     * @Route("/", name="upload_index", methods={"GET"})
     */
    public function index(UploadRepository $uploadRepository): Response
    {
        return $this->render('upload/index.html.twig', [
            'uploads' => $uploadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="upload_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            return $this->redirectToRoute('upload_index');
        }

        return $this->render('upload/new.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_show", methods={"GET"})
     */
    public function show(Upload $upload): Response
    {
        return $this->render('upload/show.html.twig', [
            'upload' => $upload,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="upload_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Upload $upload): Response
    {
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('upload_index');
        }

        return $this->render('upload/edit.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Upload $upload): Response
    {
        if ($this->isCsrfTokenValid('delete'.$upload->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($upload);
            $entityManager->flush();
        }

        return $this->redirectToRoute('upload_index');
    }
}
