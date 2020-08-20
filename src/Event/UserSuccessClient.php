<?php
namespace App\Event;
use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserSuccessClient implements EventSubscriberInterface

{
    /**
     * @var Mailer
     */
    private $mailer;
    
    
    public function __construct(Mailer $mailer)
    
    {
        $this->mailer =$mailer;
    
    }
    public static function getSubscribedEvents () 
    
    {
        
        return [
            
            UserPaymentEvent::NAME=>'onUserPayment'
          //  UserSuccessPaymentEvent::NAME=>'onUserPayment'
            ];
    }
    
    
    public function onUserPayment(UserPaymentEvent $event)
    {
        
       $this->mailer->SendEmailSuccessPayment($event->getpaidUser());
        
    }
    
}
?>