<?php
namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class UserSubscriber implements EventSubscriberInterface

{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    
    /**
     * @var \Twig_Environment
     */
    private $twig;
    
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    
    {
        $this->mailer =$mailer;
        $this->twig= $twig;
            
    }
    public static function getSubscribedEvents () 
    
    {
        
        return [
            
            UserRegisterEvent::NAME=>'onUserRegister'
            ];
    }
    
    public function onUserRegister( UserRegisterEvent $event)
    {
        
        $body = $this ->twig->render('mail/registration.html.twig', [
            
            'user' => $event->getRegisteredUser()
            
            ]);
        $message = (new \Swift_Message())
        ->setFrom('contact@iwy-contrat.com')
        ->setTo($event->getRegisteredUser()->getUser()->getEmail())
        ->setBody($body, 'text/html');
        
        $this->mailer->send($message);
        
    }
    
    
}
?>