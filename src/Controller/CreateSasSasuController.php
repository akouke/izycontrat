<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Company;
use App\Entity\Person;
use App\Entity\User;
use App\Entity\AssociateCompanyInfo;
use App\Entity\ActivitySector;
use App\Form\CompanyType;
use App\Form\ClientSarlType;
use App\Form\UserSarlType;
use App\Form\AssociatePersonType;
use App\Form\Associate1Type;
use App\Form\Associate2Type;
use App\Form\Associate3Type;
use App\Form\Associate4Type;
use App\Form\Associate5Type;
use App\Form\AssociateCompanyType;
use App\Form\AssociateCompany2Type;
use App\Form\AssociateCompany3Type;
use App\Repository\CompaniesTypesRepository;
use App\Repository\ActivitySectorRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Security\UserAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Dompdf\Dompdf;
use Dompdf\Options;
use NumberToWords\NumberToWords;
use App\Event\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\UserPaymentEvent;
use App\Event\UserInfoEvent;

class CreateSasSasuController extends AbstractController
{
    
    /**
     * @Route("/create/sas", name="create_sas")
     */
    public function createSas(GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, 
                              EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, 
                              CompaniesTypesRepository $companyTypeRecup, Request $request,
                              ActivitySectorRepository $activitySectorRecup, UserRepository $recupEmail,
                              EventDispatcherInterface $eventDispatcher)
    {
         $isConnected = false;
         
          if($this->getUser()){
             $isConnected = true;
         }
         
         $company = new Company();
         $person = new Person();
         $user = new User();
         
         $activitySector = new ActivitySector();
         
         $associate1CompanyInfo = new AssociateCompanyInfo();
         $associate2CompanyInfo = new AssociateCompanyInfo();
         $associate3CompanyInfo = new AssociateCompanyInfo();
         $associate4CompanyInfo = new AssociateCompanyInfo();
         $associate5CompanyInfo = new AssociateCompanyInfo();
         
         $associateCompany1 = new AssociateCompanyInfo();
         $associateCompany2 = new AssociateCompanyInfo();
         $associateCompany3 = new AssociateCompanyInfo();
         
         $associe1 = new Person();
         $associe2 = new Person();
         $associe3 = new Person();
         $associe4 = new Person();
         $associe5 = new Person();
         
    
         $formCompany = $this->createForm(CompanyType::class, $company);
         $formPerson = $this->createForm(ClientSarlType::class, $person);
         $formUser = $this->createForm(UserSarlType::class, $user);
         
         $formAssocie1 = $this->createForm(Associate1Type::class, $associe1);
         $formAssocie2 = $this->createForm(Associate2Type::class, $associe2);
         $formAssocie3 = $this->createForm(Associate3Type::class, $associe3);
         $formAssocie4 = $this->createForm(Associate4Type::class, $associe4);
         $formAssocie5 = $this->createForm(Associate5Type::class, $associe5);
         
         $formAssociateCompany = $this->createForm(AssociateCompanyType::class, $associateCompany1);
         $formAssociateCompany2 = $this->createForm(AssociateCompany2Type::class, $associateCompany2);
         $formAssociateCompany3 = $this->createForm(AssociateCompany3Type::class, $associateCompany3);
         
         $formCompany->handleRequest($request);
         $formPerson->handleRequest($request);
         $formUser->handleRequest($request);
         
         $formAssocie1->handleRequest($request);
         $formAssocie2->handleRequest($request);
         $formAssocie3->handleRequest($request);
         $formAssocie4->handleRequest($request);
         $formAssocie5->handleRequest($request);
         
         $formAssociateCompany->handleRequest($request);
         $formAssociateCompany2->handleRequest($request);
         $formAssociateCompany3->handleRequest($request);
            
            $emailUsed = false;
            if( $isConnected === false)
            {
                $emailVerification = $recupEmail->findOneByEmail($user->getEmail());
                if($emailVerification){
                    $emailUsed = true;
                }
            }
            
         if ($emailUsed !== true && $formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()){
            $recupNameActivitySector = $activitySectorRecup->findOneByIdActivitySector($request->request->all()['company']['activitySector']);
            $nameActivitySector = $recupNameActivitySector->getName();
            
           if ($nameActivitySector == 'Autres')
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                $em->persist($activitySector);
            }
            
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SAS"));
             
            if($isConnected === false){
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword( $user,"Qt7Xd4Lr" ));
             $user->setEnabled(true);
             $em->persist($user);
             $person->setUser($user);
             
             }elseif($isConnected === true){
                 $user = $this->getUser();
             }
             
             $person->setHasCompany(true);
             $company->setClient($user);
             
                // recup parts
                 $apportAssocieCompany1 = $associateCompany1->getCapitalBring();
                 $apportAssocieCompany2 = $associateCompany2->getCapitalBring();
                 $apportAssocieCompany3 = $associateCompany3->getCapitalBring();
                $apportAssocie1 = $associe1->getCapitalAmountAdding();
                $apportAssocie2 = $associe2->getCapitalAmountAdding();
                $apportAssocie3 = $associe3->getCapitalAmountAdding();
                $apportAssocie4 = $associe4->getCapitalAmountAdding();
                $apportAssocie5 = $associe5->getCapitalAmountAdding();
                
            //parts operation : repartition and (not / by 0 or null)
            $somTotal = $apportAssocie1 + $apportAssocie2 + $apportAssocie3 + $apportAssocie4 + $apportAssocie5 + $apportAssocieCompany1 + $apportAssocieCompany2 + $apportAssocieCompany3;
            $somTotal = ( $somTotal < 1 ? 1 : $somTotal);
            $company->setTotalCapital($somTotal);

            $associateCompany1->setCompanyPart($apportAssocieCompany1);
            $associateCompany2->setCompanyPart($apportAssocieCompany2);
            $associateCompany3->setCompanyPart($apportAssocieCompany3);
            
            $associe1->setAssociatePart($apportAssocie1);
            $associe2->setAssociatePart($apportAssocie2);
            $associe3->setAssociatePart($apportAssocie3);
            $associe4->setAssociatePart($apportAssocie4);
            $associe5->setAssociatePart($apportAssocie5);

             // pour un associer de type Societer
             if($associateCompany1->getName() !== null){
                 $associateCompany1->setPerson($person);
 
                 $em->persist($associateCompany1);
             }
             if($associateCompany2->getName() !== null){
                 $associateCompany2->setPerson($person);
                 
                 $em->persist($associateCompany2);
             }
             if($associateCompany3->getName() !== null){
                 $associateCompany3->setPerson($person);
                 
                 $em->persist($associateCompany3);
             }
            
            // persistance separer des associes
            if($associe1->getFirstName() !== null || $associe1->getLastName() !== null){
                $person->addMyAssociate($associe1);
                
                $em->persist($associe1);
            }
            if($associe2->getFirstName() !== null || $associe2->getLastName() !== null){
                $person->addMyAssociate($associe2);
                
                $em->persist($associe2);
            }
            if($associe3->getFirstName() !== null || $associe3->getLastName() !== null){
                $person->addMyAssociate($associe3);
                
                $em->persist($associe3);
            }
            if($associe4->getFirstName() !== null || $associe4->getLastName() !== null){
                $person->addMyAssociate($associe4);
                
                $em->persist($associe4);
            }
            if($associe5->getFirstName() !== null || $associe5->getLastName() !== null){
                $person->addMyAssociate($associe5);
                
                $em->persist($associe5);
            }
            
            $em->persist($person);
            $em->persist($company);
            $em->flush();
            
            // $UserInfoEvent = new UserInfoEvent($person);
            //     $eventDispatcher->dispatch(
            //     UserInfoEvent::NAME,
            //     $UserInfoEvent
            // ); 
            
            if($isConnected === false){

            $credentials = [
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
                // 'csrf_token' => $request->request->get('_csrf_token'),
                ];
                $request->getSession()->set(
                    Security::LAST_USERNAME,
                    $credentials['email']
                );

             $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
            
            }
            
            if( $isConnected === false)
            {
                
                $UserInfoEvent = new UserInfoEvent($person);
                $eventDispatcher->dispatch(
                UserInfoEvent::NAME,
                $UserInfoEvent
               ); 
               
              $this->addFlash('success', 'Vos informations ont ete bien enregistrees. Un mail contenant vos informations de connexion vous est envoye');
            }
            else{
                $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            }
            
            // $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation');

        }   

        
         return $this->render('create_entreprise/sas_sasu/sas_form.html.twig', [
            'typeStatut' => 'SAS',
            'formSas' => $formCompany->createView(),
            'formPerson' => $formPerson->createView(),
            'formUser' => $formUser->createView(),
            'formAssocie1' => $formAssocie1->createView(),
            'formAssocie2' => $formAssocie2->createView(),
            'formAssocie3' => $formAssocie3->createView(),
            'formAssocie4' => $formAssocie4->createView(),
            'formAssocie5' => $formAssocie5->createView(),
            'formAssociateCompany' => $formAssociateCompany->createView(),
            'formAssociateCompany2' => $formAssociateCompany2->createView(),
            'formAssociateCompany3' => $formAssociateCompany3->createView(),
            'emailUsed' => $emailUsed,
            'isConnected' => $isConnected,
            'user' => $user,
        ]);

    }
    
     /**
     * @Route("/create/sasu", name="create_sasu")
     */
    public function createSasu(GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, 
                               EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, 
                               CompaniesTypesRepository $companyTypeRecup, Request $request, 
                               ActivitySectorRepository $activitySectorRecup, UserRepository $recupEmail,
                               EventDispatcherInterface $eventDispatcher)
    {
        $isConnected = false;
         
          if($this->getUser()){
             $isConnected = true;
         }
               
         $company = new Company();
         $person = new Person();
         $user = new User();
         
         $activitySector = new ActivitySector();
    
         $formCompany = $this->createForm(CompanyType::class, $company);
         $formPerson = $this->createForm(ClientSarlType::class, $person);
         $formUser = $this->createForm(UserSarlType::class, $user);
         
         $formCompany->handleRequest($request);
         $formPerson->handleRequest($request);
         $formUser->handleRequest($request);

        $emailUsed = false;
        if( $isConnected === false)
        {
            $emailVerification = $recupEmail->findOneByEmail($user->getEmail());
            if($emailVerification){
                $emailUsed = true;
            }
        }
            
        if ($emailUsed !== true && $formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()) 
        {
           $recupNameActivitySector = $activitySectorRecup->findOneByIdActivitySector($request->request->all()['company']['activitySector']);
            $nameActivitySector = $recupNameActivitySector->getName();
            
           if ($nameActivitySector == 'Autres')
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                $em->persist($activitySector);
            }
            
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SASU"));
             
             
             if($isConnected === false){
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword( $user,"Qt7Xd4Lr" ));
             $user->setEnabled(true);
             $em->persist($user);
             $person->setUser($user);
             
             }elseif($isConnected === true){
                 $user = $this->getUser();
             }
              
             $person->setHasCompany(true);
             $company->setClient($user);
            
            $em->persist($company);
            $em->persist($person);
            $em->flush();
            
            // $UserInfoEvent = new UserInfoEvent($person);
            //     $eventDispatcher->dispatch(
            //     UserInfoEvent::NAME,
            //     $UserInfoEvent
            // ); 
            
            
            if( $isConnected === false ){
            $credentials = [
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
                ];
                $request->getSession()->set(
                    Security::LAST_USERNAME,
                    $credentials['email']
                );

             $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
            }
            
            if( $isConnected === false)
            {
                
                $UserInfoEvent = new UserInfoEvent($person);
                $eventDispatcher->dispatch(
                UserInfoEvent::NAME,
                $UserInfoEvent
               ); 
               
              $this->addFlash('success', 'Vos informations ont ete bien enregistrees. Un mail contenant vos informations de connexion vous est envoye');
            }
            else{
                $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            }
            
            // $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation', [
                // 'user' => $user->getEmail(),
                ]);


        }        
         return $this->render('create_entreprise/sas_sasu/sas_form.html.twig', [
            'typeStatut' => 'SASU',
            'formSasu' => $formCompany->createView(),
            'formSasuPerson' => $formPerson->createView(),
            'formSasuUser' => $formUser->createView(),
            'emailUsed' => $emailUsed,
            'isConnected' => $isConnected,
            'user' => $user,
        ]);

    }
    
      /**
     * @Route("/create/entreprise/sci", name="create_sci") 
     */
     public function createSCI(GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, 
                               EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, 
                               CompaniesTypesRepository $companyTypeRecup, Request $request,
                               ActivitySectorRepository $activitySectorRecup, UserRepository $recupEmail,
                               EventDispatcherInterface $eventDispatcher)
     {
         $isConnected = false;
         
          if($this->getUser()){
             $isConnected = true;
         }
         
         $company = new Company();
         $person = new Person();
         $user = new User();
         
         $activitySector = new ActivitySector();
         
         $associate1CompanyInfo = new AssociateCompanyInfo();
         $associate2CompanyInfo = new AssociateCompanyInfo();
         $associate3CompanyInfo = new AssociateCompanyInfo();
         $associate4CompanyInfo = new AssociateCompanyInfo();
         $associate5CompanyInfo = new AssociateCompanyInfo();
         
         $associateCompany1 = new AssociateCompanyInfo();
         $associateCompany2 = new AssociateCompanyInfo();
         $associateCompany3 = new AssociateCompanyInfo();
         
         $associe1 = new Person();
         $associe2 = new Person();
         $associe3 = new Person();
         $associe4 = new Person();
         $associe5 = new Person();
         
    
         $formCompany = $this->createForm(CompanyType::class, $company);
         $formPerson = $this->createForm(ClientSarlType::class, $person);
         $formUser = $this->createForm(UserSarlType::class, $user);
         
         $formAssocie1 = $this->createForm(Associate1Type::class, $associe1);
         $formAssocie2 = $this->createForm(Associate2Type::class, $associe2);
         $formAssocie3 = $this->createForm(Associate3Type::class, $associe3);
         $formAssocie4 = $this->createForm(Associate4Type::class, $associe4);
         $formAssocie5 = $this->createForm(Associate5Type::class, $associe5);
         
         $formAssociateCompany = $this->createForm(AssociateCompanyType::class, $associateCompany1);
         $formAssociateCompany2 = $this->createForm(AssociateCompany2Type::class, $associateCompany2);
         $formAssociateCompany3 = $this->createForm(AssociateCompany3Type::class, $associateCompany3);
         
         $formCompany->handleRequest($request);
         $formPerson->handleRequest($request);
         $formUser->handleRequest($request);
         
         $formAssocie1->handleRequest($request);
         $formAssocie2->handleRequest($request);
         $formAssocie3->handleRequest($request);
         $formAssocie4->handleRequest($request);
         $formAssocie5->handleRequest($request);
         
         $formAssociateCompany->handleRequest($request);
         $formAssociateCompany2->handleRequest($request);
         $formAssociateCompany3->handleRequest($request);
          
          $emailUsed = false;
          if( $isConnected === false)
          {
            $emailVerification = $recupEmail->findOneByEmail($user->getEmail());
            if($emailVerification){
                $emailUsed = true;
            }
          }
            
         if ($emailUsed !== true && $formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()){
            
            $recupNameActivitySector = $activitySectorRecup->findOneByIdActivitySector($request->request->all()['company']['activitySector']);
            $nameActivitySector = $recupNameActivitySector->getName();
            
           if ($nameActivitySector == 'Autres')
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                $em->persist($activitySector);
            }
            
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SCI"));
             
             if($isConnected === false){
                 
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword(
                    $user,
                    "Qt7Xd4Lr" ));
            $user->setEnabled(true);
             $em->persist($user);
             $person->setUser($user);
             
             }elseif($isConnected === true){
                 $user = $this->getUser();
             }
             
             $person->setHasCompany(true);
             $company->setClient($user);
               // recup parts
                 $apportAssocieCompany1 = $associateCompany1->getCapitalBring();
                 $apportAssocieCompany2 = $associateCompany2->getCapitalBring();
                 $apportAssocieCompany3 = $associateCompany3->getCapitalBring();
                $apportAssocie1 = $associe1->getCapitalAmountAdding();
                $apportAssocie2 = $associe2->getCapitalAmountAdding();
                $apportAssocie3 = $associe3->getCapitalAmountAdding();
                $apportAssocie4 = $associe4->getCapitalAmountAdding();
                $apportAssocie5 = $associe5->getCapitalAmountAdding();
                
            //parts operation : repartition and (not / by 0 or null)
            $somTotal = $apportAssocie1 + $apportAssocie2 + $apportAssocie3 + $apportAssocie4 + $apportAssocie5 + $apportAssocieCompany1 + $apportAssocieCompany2 + $apportAssocieCompany3;
            $somTotal = ( $somTotal < 1 ? 1 : $somTotal);
            $company->setTotalCapital($somTotal);

            $associateCompany1->setCompanyPart($apportAssocieCompany1);
            $associateCompany2->setCompanyPart($apportAssocieCompany2);
            $associateCompany3->setCompanyPart($apportAssocieCompany3);
            
            $associe1->setAssociatePart($apportAssocie1);
            $associe2->setAssociatePart($apportAssocie2);
            $associe3->setAssociatePart($apportAssocie3);
            $associe4->setAssociatePart($apportAssocie4);
            $associe5->setAssociatePart($apportAssocie5);
             // pour un associer de type Societer
             if($associateCompany1->getName() !== null){
                 $associateCompany1->setPerson($person);
                 $em->persist($associateCompany1);
             }
             if($associateCompany2->getName() !== null){
                 $associateCompany2->setPerson($person);
                 $em->persist($associateCompany2);
             }
             if($associateCompany3->getName() !== null){
                 $associateCompany3->setPerson($person);
                 $em->persist($associateCompany3);
             }
            
            // persistance separer des associes
            if($associe1->getFirstName() !== null || $associe1->getLastName() !== null){
                $person->addMyAssociate($associe1);
                $em->persist($associe1);
            }
            if($associe2->getFirstName() !== null || $associe2->getLastName() !== null){
                $person->addMyAssociate($associe2);
                $em->persist($associe2);
            }
            if($associe3->getFirstName() !== null || $associe3->getLastName() !== null){
                $person->addMyAssociate($associe3);
                $em->persist($associe3);
            }
            if($associe4->getFirstName() !== null || $associe4->getLastName() !== null){
                $person->addMyAssociate($associe4);
                $em->persist($associe4);
            }
            if($associe5->getFirstName() !== null || $associe5->getLastName() !== null){
                $person->addMyAssociate($associe5);
                $em->persist($associe5);
            }
            
            $em->persist($person);
            $em->persist($company);
            $em->flush();
            
            // $UserInfoEvent = new UserInfoEvent($person);
            //     $eventDispatcher->dispatch(
            //     UserInfoEvent::NAME,
            //     $UserInfoEvent
            // ); 
            
           
           if( $isConnected === false)
           {
            $credentials = [
                'password' => $user->getPassword(),
                'email' => $user->getEmail(),
                ];
                $request->getSession()->set(
                    Security::LAST_USERNAME,
                    $credentials['email']
                );

             $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
           }
           
           if( $isConnected === false)
            {
                
                $UserInfoEvent = new UserInfoEvent($person);
                $eventDispatcher->dispatch(
                UserInfoEvent::NAME,
                $UserInfoEvent
               ); 
               
              $this->addFlash('success', 'Vos informations ont ete bien enregistrees. Un mail contenant vos informations de connexion vous est envoye');
            }
            else{
                $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            }
            
            // $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation');

        }   
        
        return $this->render('create_entreprise/sci/SCI_form.html.twig', [
            'formPerson' => $formPerson->createView(),
            'formUser' => $formUser->createView(),
            'formAssocie1' => $formAssocie1->createView(),
            'formAssocie2' => $formAssocie2->createView(),
            'formAssocie3' => $formAssocie3->createView(),
            'formAssocie4' => $formAssocie4->createView(),
            'formAssocie5' => $formAssocie5->createView(),
            'formAssociateCompany' => $formAssociateCompany->createView(),
            'formAssociateCompany2' => $formAssociateCompany2->createView(),
            'formAssociateCompany3' => $formAssociateCompany3->createView(), 
            'formSci' => $formCompany->createView(),
            'emailUsed' => $emailUsed,
            'isConnected' => $isConnected,
            'user' => $user,
        ]);
    }
    
}
