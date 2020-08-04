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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateEntrepriseController extends AbstractController
{
    /**
     * @Route("/create/entreprise", name="create_entreprise")
     */
    public function index()
    {
        return $this->render('create_entreprise/create_entreprise.html.twig', [
            'controller_name' => 'CreateEntrepriseController',
            'controller_firstname' => 'M. xxxxxx',
        ]);
    }
    
     /**
     * @Route("/create/comparatif", name="comparatif_statut")
     */
    public function comparatifStatut()
    {
        return $this->render('create_entreprise/comparatif_statut.html.twig');
    }
    
    /**
     * @Route("/create/entreprise/sarl", name="create_sarl") 
     */
     public function createSarl (Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, CompaniesTypesRepository $companyTypeRecup)
     {
         $company = new Company();
         $person = new Person();
         $user = new User();
         
         $activitySector = new ActivitySector();
         
         $associate1CompanyInfo = new AssociateCompanyInfo();
         $associate2CompanyInfo = new AssociateCompanyInfo();
         $associate3CompanyInfo = new AssociateCompanyInfo();
         $associate4CompanyInfo = new AssociateCompanyInfo();
         $associate5CompanyInfo = new AssociateCompanyInfo();
         
         $associateCompany = new AssociateCompanyInfo();
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
         
         $formAssociateCompany = $this->createForm(AssociateCompanyType::class, $associateCompany);
         $formAssociateCompany2 = $this->createForm(AssociateCompany2Type::class, $associateCompany2);
         $formAssociateCompany3 = $this->createForm(AssociateCompany3Type::class, $associateCompany3);
        //  $formAssocie2 = $this->createForm(AssociatePersonType::class, $associe2);
         
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
        //  $formAssocie2->handleRequest($request);
            
        // dump($company, $person, $user, $associe1, $associe2);
        
        if ($formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()){
            
            if ($request->request->all()['company']['activitySector'] === "14")
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                
                $em->persist($activitySector);
            }
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SARL"));
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword(
                    $user,
                    "izycontratpassword"
                    // $request->request->all()['user_sarl']['password']
                ));
             $person->setUser($user);
             
             // pour un associer de type Societer
             if($associateCompany->getName() !== null){
                 $associateCompany->setPerson($person);
                 $em->persist($associateCompany);
                //  dd($associateCompany);
             }
             if($associateCompany2->getName() !== null){
                 $associateCompany2->setPerson($person);
                 $em->persist($associateCompany2);
                //  dd($associateCompany);
             }
             if($associateCompany3->getName() !== null){
                 $associateCompany3->setPerson($person);
                 $em->persist($associateCompany3);
                //  dd($associateCompany);
             }
            //  dd($associateCompany, $associateCompany2, $associateCompany3, $request);
            
            // persistance separer des associes
            if($associe1->getFirstName() !== null || $associe1->getLastName() !== null){
                // $em->persist($associe1);
                $person->addMyAssociate($associe1);
                // $associate1CompanyInfo->setPerson($associe1);
                $em->persist($associe1);
                // $em->persist($associate1CompanyInfo);
                // $em->flush();
                // dd($associate1CompanyInfo, $associe1);
            }
            if($associe2->getFirstName() !== null || $associe2->getLastName() !== null){
                // $associate2CompanyInfo->setPerson($associe2);
                // $em->persist($associate2CompanyInfo);
                // dd($associate2CompanyInfo, $associe2);
                $person->addMyAssociate($associe2);
                $em->persist($associe2);
            }
            if($associe3->getFirstName() !== null || $associe3->getLastName() !== null){
                // $associate3CompanyInfo->setPerson($associe3);
                // $em->persist($associate3CompanyInfo);
                // dd($associate3CompanyInfo, $associe3);
                $person->addMyAssociate($associe3);
                $em->persist($associe3);
            }
            if($associe4->getFirstName() !== null || $associe4->getLastName() !== null){
                // $associate4CompanyInfo->setPerson($associe4);
                // $em->persist($associate4CompanyInfo);
                // dd($associate4CompanyInfo, $associe4);
                $person->addMyAssociate($associe4);
                $em->persist($associe4);
            }
            if($associe5->getFirstName() !== null || $associe5->getLastName() !== null){
                // $associate5CompanyInfo->setPerson($associe5);
                // $em->persist($associate5CompanyInfo);
                // dd($associate5CompanyInfo, $associe5);
                $person->addMyAssociate($associe5);
                $em->persist($associe5);
            }
                // dd( $person, $user, $company, $request, $associateCompany);
            //   $person->setPhoneNumber($formCompany->get('phoneNumber')->getData());

            $em->persist($user);
            $em->persist($person);
            $em->persist($company);
            $em->flush();
            
            $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation'
            // ,
            // ['id' => $company->getId()]
            );

            // $entityManager->flush();
        }   

        return $this->render('create_entreprise/sarl/SARL_form.html.twig', [
            'formSarl' => $formCompany->createView(),
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
            'SARL' => "SARL",
            // 'EURL' => "EURL"
            
        ]);
    }
    
    /**
     * @Route("/create/entreprise/sarl/prestation", name="create_sarl_prestation") 
     */
     public function createSarlPrestation (Request $request, EntityManagerInterface $em)
     {
         
         return $this->render('create_entreprise/sarl/SARL_form_prestation.html.twig', [
            
        ]);
         
     }
     
     /**
     * @Route("/create/entreprise/sarl/payment", name="create_sarl_payement") 
     */
     public function createSarlPayment (Request $request, EntityManagerInterface $em)
     {
         
         return $this->render('create_entreprise/sarl/SARL_form_payement.html.twig', [
            
        ]);
         
     }
     
     /**
     * @Route("/create/entreprise/sarl/status", name="create_sarl_status") 
     */
     public function createSarlStatus (Request $request, EntityManagerInterface $em)
     {
         
         return $this->render('create_entreprise/sarl/SARL_status.html.twig', [
            
        ]);
         
     }
    
    
    /**
     * @Route("/create/entreprise/eurl", name="create_eurl") 
     */
     public function createEurl(Request $request)
     {
         
        
         $company = new Company();
         $person = new Person();
         $user = new User();
    
         $formCompany = $this->createForm(CompanyType::class, $company);
         $formPerson = $this->createForm(ClientSarlType::class, $person);
         $formUser = $this->createForm(UserSarlType::class, $user);
         
         $formCompany->handleRequest($request);
         $formPerson->handleRequest($request);
         $formUser->handleRequest($request);
            
        dump($company, $person, $user);
        if ($formCompany->isSubmitted() ) {
        dd($formCompany);
            // $person->setAddress($formCompany->get('address')->getData());
            // $person->setCountry($formCompany->get('country')->getData());
            // $person->setFirstName($formCompany->get('firstName')->getData());
            // $person->setLastName($formCompany->get('lastName')->getData());
            // $person->setPhoneNumber($formCompany->get('phoneNumber')->getData());
            // $person->setSpecialization($formCompany->get('specialization')->getData());
            // $user->setEmail($request->request->get('registration_user')['user']['email']);
            // $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $request->request->all()['registration_user']['user']['password']
            //     )
            // );
            $user->setIsVerified(false);
            $user->setRoles(['ROLE_CLIENT']);
            // $entityManager = $this->getDoctrine()->getManager();

            // $entityManager->persist($user);
            // $entityManager->persist($person);

            // $entityManager->flush();
        }        
    
        return $this->render('create_entreprise/EURL_form.html.twig', [
             'formEurl' => $formCompany->createView(),
        ]);
    }
    
    /**
     * @Route("/create/entreprise/sasu", name="create_sasu") 
     */
     public function createSasu()
     {
        return $this->render('create_entreprise/SASU_form.html.twig', [
            
        ]);
    }
    
    
    /**
     * @Route("/create/entreprise/micro-entreprise", name="create_m-e") 
     */
     public function createMicroEntreprise()
     {
        return $this->render('create_entreprise/M-E_form.html.twig', [
            
        ]);
    }
}
