<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\EditPasswordType;
use App\Security\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class EditPasswordController extends AbstractController
{
    /**
     * @Route("/dashboard/change_mdp", name="change_password")
     * @param Request $request
     * @return Response
     */
    public function changePassword(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('edit_password')['oldPassword'];

// Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($newEncodedPassword);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->render('dashboard\profile.html.twig');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('dashboard\change_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

