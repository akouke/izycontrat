<?php

namespace App\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
use App\Entity\User;
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
        ->setFrom($this->emailFrom)
        ->setTo($person->getUser()->getEmail())
        ->setBody($body, 'text/html');
        
        $this->mailer->send($message);
    }


}

?>