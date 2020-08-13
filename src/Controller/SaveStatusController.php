<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Company;
use App\Entity\Person;
use App\Entity\User;
use App\Entity\Upload;
use App\Entity\AssociateCompanyInfo;
use App\Entity\ActivitySector;
use App\Repository\CompaniesTypesRepository;
use App\Repository\ActivitySectorRepository;
use App\Repository\UserRepository;
use App\Repository\PersonRepository;
use App\Repository\CompanyRepository;
use App\Repository\AssociateCompanyInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Security\UserAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Dompdf\Dompdf;
use Dompdf\Options;
use NumberToWords\NumberToWords;
use Symfony\Component\HttpFoundation\Response;

class SaveStatusController extends AbstractController
{
     
   /**
    * @Route("/create/save", name="save_status")
   */
    public function saveStatut(string $dossierClient, EntityManagerInterface $em, PersonRepository $detailPerson, 
                                CompanyRepository $detailCompany, AssociateCompanyInfoRepository $detailCompanyAssociate)
    {
        if(!$this->getUser()){
             return $this->redirectToRoute('create_entreprise' );
         }

         // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // number transformer to words
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('fr');
        
        $user = $this->getUser();
        $recupPerson = $detailPerson->findOneByUser($user->getId());
        $recupCompany = $detailCompany->findOneByClient($user->getId());
        
        $associe1 = $associe2 = $associe3 = $associe4 = $associe5 = null;
        $associeCompany1 = $associeCompany2 = $associeCompany3 = $associeCompany4 = null;
        
        $civility = $firstName = $lastName = $phoneNumber = $address = $country = $capital 
        = $married = $nationality = $dateBirth = $dateBirth = $hasCompany = $score 
        = $specialization =  $associatePart = null;
        
        $toWordApportAssocie1 = $toWordApportAssocie2 = $toWordApportAssocie3 = $toWordApportAssocie4 = $toWordApportAssocie5 =
        $toWordApportAssocieCompany1 = $toWordApportAssocieCompany2 = $toWordApportAssocieCompany3 = 0;
        
        
        if($recupPerson){
            $civility = $recupPerson->getGender();
            $firstName = $recupPerson->getFirstName();
            $lastName = $recupPerson->getLastName();
            $phoneNumber = $recupPerson->getPhoneNumber();
            $address = $recupPerson->getAddress();
            $country = $recupPerson->getCountry();
            $capital = $recupPerson->getCapitalAmountAdding();
            $married = $recupPerson->getMarried();
            if($married === true){
                $married = 'Marié(e)';
            }
            elseif($married === false ){
                $married = 'Célibataire';
            }else{
                $married = null;
            }
            $nationality = $recupPerson->getNationality();
            $dateBirth = $recupPerson->getDateBirth();
            
            $hasCompany = $recupPerson->getHasCompany();
            $score = $recupPerson->getScore();
            $specialization = $recupPerson->getSpecialization();
            $associatePart = $recupPerson->getAssociatePart();

            $recupePersonAssocie = $detailPerson->findByAssociates($recupPerson->getId());
            $iPerson = 0;
            if($recupePersonAssocie)
            {
                //.length will go out in php 
                foreach( $recupePersonAssocie as $ligne)
                {
                    ++$iPerson;
                }
           }   

            if($iPerson == 1)
            {
                $associe1 = $recupePersonAssocie[$iPerson-1];
                $toWordApportAssocie1 = $associe1->getCapitalAmountAdding();
            }
            elseif($iPerson == 2)
            {
                $associe1 = $recupePersonAssocie[$iPerson-1];
                $associe2 = $recupePersonAssocie[$iPerson-2];
                $toWordApportAssocie1 = $associe1->getCapitalAmountAdding();
                $toWordApportAssocie2 = $associe2->getCapitalAmountAdding();
            }
            elseif($iPerson == 3)
            {
                $associe1 = $recupePersonAssocie[$iPerson-1];
                $associe2 = $recupePersonAssocie[$iPerson-2];
                $associe3 = $recupePersonAssocie[$iPerson-3];
                $toWordApportAssocie1 = $numberTransformer->toWords($associe1->getCapitalAmountAdding());
                $toWordApportAssocie2 = $numberTransformer->toWords($associe2->getCapitalAmountAdding());
                $toWordApportAssocie3 = $numberTransformer->toWords($associe3->getCapitalAmountAdding());
            }
            elseif($iPerson == 4)
            {
                $associe1 = $recupePersonAssocie[$iPerson-1];
                $associe2 = $recupePersonAssocie[$iPerson-2];
                $associe3 = $recupePersonAssocie[$iPerson-3];
                $associe4 = $recupePersonAssocie[$iPerson-4];
                $toWordApportAssocie1 = $numberTransformer->toWords($associe1->getCapitalAmountAdding());
                $toWordApportAssocie2 = $numberTransformer->toWords($associe2->getCapitalAmountAdding());
                $toWordApportAssocie3 = $numberTransformer->toWords($associe3->getCapitalAmountAdding());
                $toWordApportAssocie4 = $numberTransformer->toWords($associe4->getCapitalAmountAdding());
            }
            elseif($iPerson == 5)
            {
                $associe1 = $recupePersonAssocie[$iPerson-1];
                $associe2 = $recupePersonAssocie[$iPerson-2];
                $associe3 = $recupePersonAssocie[$iPerson-3];
                $associe4 = $recupePersonAssocie[$iPerson-4];
                $associe5 = $recupePersonAssocie[$iPerson-5];
                $toWordApportAssocie1 = $numberTransformer->toWords($associe1->getCapitalAmountAdding());
                $toWordApportAssocie2 = $numberTransformer->toWords($associe2->getCapitalAmountAdding());
                $toWordApportAssocie3 = $numberTransformer->toWords($associe3->getCapitalAmountAdding());
                $toWordApportAssocie4 = $numberTransformer->toWords($associe4->getCapitalAmountAdding());
                $toWordApportAssocie5 = $numberTransformer->toWords($associe5->getCapitalAmountAdding());
            }

        }
        
        if($recupCompany){
            $companyName = $recupCompany->getName();
            $companyIsCreated = $recupCompany->getIsCreated();
            $companyHasProtection = $recupCompany->getHasProtection();
            $companyHasAssociate = $recupCompany->getHasAssociate();
            $companyHasDirector = $recupCompany->getHasDirector();
            $companyHeadOffice = $recupCompany->getHeadOffice();
            $companyCapitalSocial = $recupCompany->getCapitalSocial();
            $companyBankName = $recupCompany->getBankName();
            $companyAssociates = $recupCompany->getAssociates();
            $companyAddress = $recupCompany->getAddress();
            $companyCountry = $recupCompany->getCountry();
            $companyType = $recupCompany->getCompanyType()->getName();
            $regimeMicroEntreprise = $recupCompany->getRegimeMicroEntreprise();
            $companyTradeName = $recupCompany->getTradeName();
            $companyManager = $recupCompany->getManager();
            $companyAddressManager = $recupCompany->getAddressManager();
            $activitySector = $recupCompany->getActivitySector()->getName();
            if(!$activitySector){
             $activitySector = $recupCompany->getActivitySector()->getOtherName();   
            }
            $priority = $recupCompany->getPriority()->getName();
            $president = $recupCompany->getPresident();
            $generalDirector = $recupCompany->getGeneralDirector();
            $companyTotalCapital = $recupCompany->getTotalCapital();
            $socialObject = $recupCompany->getSocialObject();
            
            $recupeCompanyAssocie = $detailCompanyAssociate->findByPerson($recupPerson->getId());

            $iCompany = 0;
            if($recupeCompanyAssocie)
            {
                //.length will go out in php 
                foreach( $recupeCompanyAssocie as $ligne)
                {
                    ++$iCompany;
                }
           }   

            if($iCompany == 1)
            {
                $associeCompany1 = $recupeCompanyAssocie[$iCompany-1];
                $toWordApportAssocieCompany1 = $numberTransformer->toWords($associeCompany1->getCapitalBring());
            }
            elseif($iCompany == 2)
            {
                $associeCompany1 = $recupeCompanyAssocie[$iCompany-1];
                $associeCompany2 = $recupeCompanyAssocie[$iCompany-2];
                $toWordApportAssocieCompany1 = $numberTransformer->toWords($associeCompany1->getCapitalBring());
                $toWordApportAssocieCompany2 = $numberTransformer->toWords($associeCompany2->getCapitalBring());
            }
            elseif($iCompany == 3)
            {
                $associeCompany1 = $recupeCompanyAssocie[$iCompany-1];
                $associeCompany2 = $recupeCompanyAssocie[$iCompany-2];
                $associeCompany3 = $recupeCompanyAssocie[$iCompany-3];
                $toWordApportAssocieCompany1 = $numberTransformer->toWords($associeCompany1->getCapitalBring());
                $toWordApportAssocieCompany2 = $numberTransformer->toWords($associeCompany2->getCapitalBring());
                $toWordApportAssocieCompany3 = $numberTransformer->toWords($associeCompany3->getCapitalBring());
            }
            elseif($iCompany == 4)
            {
                $associeCompany1 = $recupeCompanyAssocie[$iCompany-1];
                $associeCompany2 = $recupeCompanyAssocie[$iCompany-2];
                $associeCompany3 = $recupeCompanyAssocie[$iCompany-3];
                $associeCompany4 = $recupeCompanyAssocie[$iCompany-4];
                $toWordApportAssocieCompany1 = $numberTransformer->toWords($associeCompany1->getCapitalBring());
                $toWordApportAssocieCompany2 = $numberTransformer->toWords($associeCompany2->getCapitalBring());
                $toWordApportAssocieCompany3 = $numberTransformer->toWords($associeCompany3->getCapitalBring());
                $toWordApportAssocieCompany4 = $numberTransformer->toWords($associeCompany4->getCapitalBring());

            }

        }
        $partTotal = $iCompany + $iPerson;
        if($partTotal < 1){
            $partTotal = 1;
        }
        $manager = false;
        if($companyManager == 'Oui'){
            $manager = true;
        }
        
    if($recupCompany->getCompanyType()->getName() == "SARL")
      {
        $html = $this->renderView('create_entreprise/sarl/SARL_status.html.twig', [
            'title' => "Recu Creation de SARL",
            'dateCreation' => date('d/m/Y'),
            'person' => $recupPerson,
            'civilite' => ($civility == 2 ? 'Monsieur' : 'Madame'),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'country' => $country,
            'capitalApport' => $capital,
            'situation' => $married,
            'nationality' => $nationality,
            'dateNaissance' => $dateBirth,
            'hasCompany' => $hasCompany,
            'score' => $score,
            '$specialization' => $specialization,
            'associatePart' => $associatePart,
            
            'totalToWord' => $numberTransformer->toWords($recupCompany->getTotalCapital()),
            'totalToNum' => $recupCompany->getTotalCapital(),
            
            'associe1' => $associe1,
            'associe2' => $associe2,
            'associe3' => $associe3,
            'associe4' => $associe4,
            'associe5' => $associe5,
            
            'toWordApportAssocie1' => $toWordApportAssocie1,
            'toWordApportAssocie2' => $toWordApportAssocie2,
            'toWordApportAssocie3' => $toWordApportAssocie3,
            'toWordApportAssocie4' => $toWordApportAssocie4,
            'toWordApportAssocie5' => $toWordApportAssocie5,
            
            'associeCompany1' => $associeCompany1,
            'associeCompany2' => $associeCompany2,
            'associeCompany3' => $associeCompany3,
            
            'toWordApportAssocieCompany1' => $toWordApportAssocieCompany1,
            'toWordApportAssocieCompany2' => $toWordApportAssocieCompany2,
            'toWordApportAssocieCompany3' => $toWordApportAssocieCompany3,
            
            'company' => $recupCompany,
            'companyName' => $companyName,
            'companyIscreated' => $companyIsCreated,
            'companyHasProtection' => $companyHasProtection,
            'companyHasAssociate' => $companyHasAssociate,
            'companyHasDirector' => $companyHasDirector,
            'companyHeadOffice' => $companyHeadOffice,
            'capitalNum' => $companyCapitalSocial,
            'capitalWord' => $numberTransformer->toWords($companyCapitalSocial),
            'companyCapitalSocial' => $companyCapitalSocial,
            'companyBankName' => $companyBankName,
            'companyAssociates' => $companyAssociates,
            'companyAddress' => $companyAddress,
            'companyCountry' => $companyCountry,
            'companyType' => $companyType,
            'regimeMicroEntreprise' => $regimeMicroEntreprise,
            'companyTradeName' => $companyTradeName,
            'companyManager' => $companyManager,
            'companyAddressManager' => $companyAddressManager,
            'activitySector' => $activitySector,
            'priority' => $priority,
            'president' => $president,
            'generalDirector' => $generalDirector,
            'companyTotalCapital' => $companyTotalCapital,
            'socialObject' => $socialObject,
            
            'associeCompany1' => $associeCompany1,
            'associeCompany2' => $associeCompany2,
            'associeCompany3' => $associeCompany3,
            'associeCompany4' => $associeCompany4,
            
            'totalPartNum' => $partTotal,
            'totalPartWord' => $numberTransformer->toWords($partTotal),
            'partChacuneNum' => ($companyCapitalSocial / $partTotal),
            'partChacuneWord' => $numberTransformer->toWords($companyCapitalSocial / $partTotal),
            'isManager' => $manager,
        ]);
      }

      elseif($recupCompany->getCompanyType()->getName() == "EURL")
      {
        $html = $this->renderView('create_entreprise/sarl/EURL_status.html.twig', [
            'title' => "Recu Creation de EURL",
            'dateCreation' => date('d/m/Y'),
            'person' => $recupPerson,
            'civilite' => ($civility == 2 ? 'Monsieur' : 'Madame'),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'country' => $country,
            'capitalApport' => $capital,
            'situation' => $married,
            'nationality' => $nationality,
            'dateNaissance' => $dateBirth,
            'hasCompany' => $hasCompany,
            'score' => $score,
            '$specialization' => $specialization,
            'associatePart' => $associatePart,
            
            'totalToWord' => $numberTransformer->toWords($recupCompany->getTotalCapital()),
            'totalToNum' => $recupCompany->getTotalCapital(),
            
            'associe1' => $associe1,
            'associe2' => $associe2,
            'associe3' => $associe3,
            'associe4' => $associe4,
            'associe5' => $associe5,
            
            'toWordApportAssocie1' => $toWordApportAssocie1,
            'toWordApportAssocie2' => $toWordApportAssocie2,
            'toWordApportAssocie3' => $toWordApportAssocie3,
            'toWordApportAssocie4' => $toWordApportAssocie4,
            'toWordApportAssocie5' => $toWordApportAssocie5,
            
            'associeCompany1' => $associeCompany1,
            'associeCompany2' => $associeCompany2,
            'associeCompany3' => $associeCompany3,
            
            'toWordApportAssocieCompany1' => $toWordApportAssocieCompany1,
            'toWordApportAssocieCompany2' => $toWordApportAssocieCompany2,
            'toWordApportAssocieCompany3' => $toWordApportAssocieCompany3,
            
            'company' => $recupCompany,
            'companyName' => $companyName,
            'companyIscreated' => $companyIsCreated,
            'companyHasProtection' => $companyHasProtection,
            'companyHasAssociate' => $companyHasAssociate,
            'companyHasDirector' => $companyHasDirector,
            'companyHeadOffice' => $companyHeadOffice,
            'capitalNum' => $companyCapitalSocial,
            'capitalWord' => $numberTransformer->toWords($companyCapitalSocial),
            'companyCapitalSocial' => $companyCapitalSocial,
            'companyBankName' => $companyBankName,
            'companyAssociates' => $companyAssociates,
            'companyAddress' => $companyAddress,
            'companyCountry' => $companyCountry,
            'companyType' => $companyType,
            'regimeMicroEntreprise' => $regimeMicroEntreprise,
            'companyTradeName' => $companyTradeName,
            'companyManager' => $companyManager,
            'companyAddressManager' => $companyAddressManager,
            'activitySector' => $activitySector,
            'priority' => $priority,
            'president' => $president,
            'generalDirector' => $generalDirector,
            'companyTotalCapital' => $companyTotalCapital,
            'socialObject' => $socialObject,
            
            'associeCompany1' => $associeCompany1,
            'associeCompany2' => $associeCompany2,
            'associeCompany3' => $associeCompany3,
            'associeCompany4' => $associeCompany4,
            
            'totalPartNum' => $partTotal,
            'totalPartWord' => $numberTransformer->toWords($partTotal),
            'partChacuneNum' => ($companyCapitalSocial / $partTotal),
            'partChacuneWord' => $numberTransformer->toWords($companyCapitalSocial / $partTotal),
            'isManager' => $manager,
        ]);
      }

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force/not download)
        // $dompdf->stream("mypdf.pdf", [
        //     "Attachment" => false
        // ]);

        // Store PDF Binary Data
        $output = $dompdf->output();
        
   
        /** @var User $user */
        $user=$this->getUser();

        $pdfFilepath =   $dossierClient.'/'.'statut_'.$user->getEmail().'.pdf';


        $upload = new Upload();
       
        
        $upload->setUser($user);
        $upload->setStatus('statut_'.$user->getEmail().'.pdf');

        $em->persist($upload);
   
        $em->flush();
  
        file_put_contents($pdfFilepath, $output);
        
       return $this->redirectToRoute('dashboard_home');
        
    }
    
}
