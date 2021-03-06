<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\User;
use App\Form\UploadType;
use App\Repository\UploadRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/dashboard/upload")
 */
class UploadController extends AbstractController
{
    /**
     * @Route("/", name="upload_index", methods={"GET"})
     */
    public function index(UploadRepository $uploadRepository): Response
    {
        /** @var User $user */
        $user=$this->getUser();

        $upload = $uploadRepository->findAllUpload($user);

        return $this->render('upload/index.html.twig', [
            'uploads' => $upload,
        ]);
    }

    /**
     * @Route("/new", name="upload_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        /** @var User $user */
        $user=$this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $upload->setUser($user);
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
