<?php
namespace App\Event;
use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserInfo implements EventSubscriberInterface

{
    /**
     * @var Mailer
     */
    private $mailer;
    
    
    public function __construct(Mailer $mailer)
    
    {
        $this->mailer=$mailer;
    
    }
    public static function getSubscribedEvents () 
    
    {
        
        return [
            
            UserInfoEvent::NAME=>'onUserConnexion'
          //  UserSuccessPaymentEvent::NAME=>'onUserPayment'
            ];
    }
    
    
    public function onUserConnexion(UserInfoEvent $event)
    {
        
       $this->mailer->SendEmailConnexionInfo($event->getConnexionUserInfo());
        
    }
    
}
?>