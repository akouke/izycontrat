<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Repository\UploadRepository;
use App\Form\ClientType;
use App\Form\LawyerType;
use App\Form\UserChangePasswordType;
use App\Form\RegistrationUserType;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser();
        // if(!$user){
        //     return $this->redirectToRoute('dashboard_home');
        // }
        // dd($user);
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['user' => $user]);
        return $this->render(
            'dashboard/index.html.twig',
            [
                'user' => $user,
                'person' => $person
            ]
        );
    }

    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        // if(!$user){
        //     return $this->redirectToRoute('dashboard_home');
        // }
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['user' => $user]);
        
    // dd($person);
        if ($this->isGranted(['ROLE_LAWYER'])) {
            $form = $this->createForm(LawyerType::class, $person);
        } else {
            $form = $this->createForm(ClientType::class, $person);
        }
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
                // $user->setPassword ( $passwordEncoder->encodePassword( $user, $formUser->getPassword() ));
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Le profil a bien été modifié');
        }
        return $this->render(
            'dashboard/profile.html.twig',
            [
                'form' => $form->createView(),
                // 'formUser' => $formUser->createView(),
            
            ]
        );
    }
    
     /**
     * @Route("/profile/edit", name="profile_edit_user")
     * @param Request $request
     * @return Response
     */
    public function profileEditUser(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $user = $this->getUser();
        // if(!$user){
        //     return $this->redirectToRoute('dashboard_home');
        // }
        if ($this->isGranted(['ROLE_LAWYER'])) {
            $formUser = $this->createForm(LawyerType::class, $user);
        } else {
            $formUser = $this->createForm(UserChangePasswordType::class, $user);
            // ->add('save', SubmitType::class, ['label' => "Modifier Password"]);
        }
        $formUser->handleRequest($request);
            
        if ( $request->getMethod() == "POST" )
        {
            $newPassword = $formUser->get('password')->getData();
            $lenNewPassword = strlen($newPassword);
            if($lenNewPassword < 8){
                $this->addFlash('danger', 'Votre mot de passe de '.$lenNewPassword.' caracteres est trop court! 8 caracteres au minimun');
                return $this->redirectToRoute('dashboard_profile_edit_user');
            }
            // dd($lenNewPassword);
            $oldPassword = $formUser->get('oldPassword')->getData();
            $user->setOldPassword($oldPassword);
            $checkPass = $passwordEncoder->isPasswordValid($user, $oldPassword);
            if(  $checkPass === true ) 
            {
                $user->setPassword($passwordEncoder->encodePassword( $user, $newPassword ));
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Votre mot de passe a bien été modifié');
                
                return $this->redirectToRoute('dashboard_home');
            }
        }
        return $this->render(
            'dashboard/userChangePassword.html.twig',
            [
                'formUser' => $formUser->createView(),
            
            ]
        );
    }

    /**
     * @Route("/admin/clients", name="admin_clients")
     */
    public function adminClientsList()
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('dashboard_home');
        }
        $clients = $this->getDoctrine()
            ->getRepository(Person::class)
            ->findBy(['hasCompany' => true]);
        return $this->render('dashboard/Admin/client.html.twig', ['clients' => $clients]);
    }

    /**
     * @Route("/admin/clients/{id}", name="admin_clients_show")
     * @param Person $client
     * @return Response
     */
    public function adminClientsShow(Person $client, UploadRepository $uploadsRecup, string $dossierClient)
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('dashboard_home');
        }
        
        // dd($client->getUser());
        // $uploads = $uploadsRecup->findByUser($client->getUser());
        $uploads = $uploadsRecup->findAllUpload($client->getUser());

    //   $d = $dossierClient."/";

    
    //     $mot = trim($uploads['0']->getStatus());

    //     $path = $d.$mot;
        // $d->close();
        
        // }
        // dd($uploads);
        
        return $this->render('dashboard/Admin/show.html.twig', [
            'client' => $client,
            'uploads' => $uploads,
            ]);
    }

    /**
     * @Route("/admin/avocats", name="admin_lawyers")
     */
    public function adminLawyerList()
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('dashboard_home');
        }
        $lawyers = $this->getDoctrine()
            ->getRepository(Person::class)
            ->findBy(['hasCompany' => true]);
        return $this->render('dashboard/Admin/lawyer.html.twig', ['lawyers' => $lawyers]);
    }

    /**
     * @Route("/admin/avocats/{id}", name="admin_lawyers_show")
     * @param Person $lawyer
     * @return Response
     */
    public function adminLawyerShow(Person $lawyer)
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('dashboard_home');
        }
        return $this->render('dashboard/Admin/show.html.twig', ['lawyer' => $lawyer]);
    }
    
     /**
     * @Route("/admin/client/delete/{id}", name="clients_delete")
     */
    public function deleteClient(Person $client): Response
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('dashboard_home');
        }
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
            $this->addFlash('success', 'le client a bien ete supprime');
            
        }catch (\Throwable $th) 
          {
            $this->addFlash('danger', 'la suppression n\'a pas reussit contacter l\'administrateur au besion');  
              
          }
        return $this->redirectToRoute('dashboard_admin_clients');
    }
}
