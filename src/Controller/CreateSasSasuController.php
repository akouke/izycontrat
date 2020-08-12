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
use Symfony\Component\Security\Core\Security;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

//conversion numbertoletter
// use App\Services\NumberToLetter;
use NumberToWords\NumberToWords;

class CreateSasSasuController extends AbstractController
{
    /**
     * @Route("/create/sas", name="create_sas")
     */
    public function createSas(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, CompaniesTypesRepository $companyTypeRecup)
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
            
        // dump($company, $person, $user, $associe1, $associe2);
        // dd($company, $person, $user, $associe1, $associe2);
         if ($formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()){
            
            if ($request->request->all()['company']['activitySector'] === "14")
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                
                $em->persist($activitySector);
            }
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SAS"));
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
            $em->persist($user);
            $em->persist($person);
            $em->persist($company);
// dd( $person, $user, $company, $request, $associateCompany, $associateCompany2);
            $em->flush();
            
            $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
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
        ]);

    }
    
     /**
     * @Route("/create/sasu", name="create_sasu")
     */
    public function createSasu(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, CompaniesTypesRepository $companyTypeRecup)
    {
        
               
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
            
        // dump($company, $person, $user);
        
        if ($formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()) 
        {
            
           if ($request->request->all()['company']['activitySector'] === "14")
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                
                $em->persist($activitySector);
            }
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SASU"));
             
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword( $user,"izycontratpassword" ));
              
             $person->setUser($user);
            
            $em->persist($company);
            $em->persist($user);
            $em->persist($person);
            
        // dd($formCompany, $company, $user, $person);
            // dd($this->getUser(), $user->getEmail() );
            $em->flush();
            
            $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation', [
                'user' => $user->getEmail(),
                ]);


        }        
         return $this->render('create_entreprise/sas_sasu/sas_form.html.twig', [
            'typeStatut' => 'SASU',
            'formSasu' => $formCompany->createView(),
            'formSasuPerson' => $formPerson->createView(),
            'formSasuUser' => $formUser->createView(),
        ]);

    }
    
      /**
     * @Route("/create/entreprise/sci", name="create_sci") 
     */
     public function createSCI(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, CompaniesTypesRepository $companyTypeRecup)
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
            
        // dump($company, $person, $user, $associe1, $associe2);
        // dd($company, $person, $user, $associe1, $associe2);
         if ($formCompany->isSubmitted() && $formPerson->isSubmitted() && $formUser->isSubmitted()){
            
            if ($request->request->all()['company']['activitySector'] === "14")
            {
                $company->setActivitySector( $activitySector->setNameOther($request->request->all()['company_activitySector_autre']) );
                
                $em->persist($activitySector);
            }
             $company->setIsCreated(false);
             $company->setCompanyType($companyTypeRecup->findOneByName("SCI"));
             $user->setIsVerified(false);
             $user->setRoles(['ROLE_CLIENT']);
             $user->setPassword ( $passwordEncoder->encodePassword(
                    $user,
                    "izycontratpassword" ));
               
             $person->setUser($user);
             
             // pour un associer de type Societer
             if($associateCompany->getName() !== null){
                 $associateCompany->setPerson($person);
                 $em->persist($associateCompany);
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
            $em->persist($user);
            $em->persist($person);
            $em->persist($company);
// dd( $person, $user, $company, $request, $associateCompany, $associateCompany2);
            $em->flush();
            
            $this->addFlash('success', 'Vos informations ont ete bien enregistrees');
            return $this->redirectToRoute('create_sarl_prestation');

        }   
        
        return $this->render('create_entreprise/sci/SCI_form.html.twig', [
         'formSci' => $formCompany->createView(),
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
        ]);
    }
    
}
