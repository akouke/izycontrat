<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
     /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
        
    }
    // /**
    //  * @Route("/connexion", name="login")
    //  * @param AuthenticationUtils $authenticationUtils
    //  * @return Response
    //  */
    // public function login(AuthenticationUtils $authenticationUtils): Response
    // {
    //     // if ($this->getUser()) {
    //     //     return $this->redirectToRoute('target_path');
    //     // }

    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    // }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    /**
     * @Route("/confirm/{token}", name="security_confirmation")
     */
    public function confirm(
            string $token,
            UserRepository $userRepository,
            EntityManagerInterface $entityManager)

    {
        $user = $userRepository->findOneby([

            'confirmationToken' => $token

            ]);
            if (null !=$user){
                $user->setEnabled('true');
                $user->setConfirmationToken('');
                $entityManager->flush();
            }

        return new Response($this->render('security/confirmation.html.twig',[

            'user' => $user
            ])
            );

    }
}
