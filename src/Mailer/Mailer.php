<?php

namespace App\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Entity\User;
use Twig\Environment;
use App\Entity\Person;


class Mailer
{
   
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
     /**
     * @var \Twig_environment
     */
    private $twig;
    /**
     * @var string
     */
    private $emailFrom;
    
  
    public function __construct (\Swift_Mailer $mailer, environment $twig, string $emailFrom) 
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->emailFrom = $emailFrom;
     
    }

    public function SendEmailConfirmation (Person $person) 
    {
           
        $body = $this ->twig->render('mail/registration.html.twig', [
            
            'user' => $person
            
            ]);
        $message = (new \Swift_Message())
        ->setSubject('IZYcontrat Confirmation Email ')
        ->setFrom($this->emailFrom)
        ->setTo($person->getUser()->getEmail())
        ->setBody($body, 'text/html');
        //->attach(Swift_Attachment::fromPath('my-document.pdf'))
        
        $this->mailer->send($message);
    }
    
    public function SendEmailSuccessPayment (Person $person) 
    {
           
        $body = $this ->twig->render('mail/success_mail.html.twig', [
            
            'user' => $person
            
            ]);
        $message = (new \Swift_Message())
        ->setSubject('IZYcontrat Confirmation paiement ')
        ->setFrom($this->emailFrom)
        ->setTo($person->getUser()->getEmail())
        ->setBody($body, 'text/html');
        //->attach(Swift_Attachment::fromPath('my-document.pdf'))
        
        $this->mailer->send($message);
    }
    
    
   
    
    
      


}

?>