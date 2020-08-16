<?php
namespace App\Event;
use App\Mailer\MailerPassword;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserResetPassword implements EventSubscriberInterface

{
    /**
     * @var MailerPassword
     */
    private $mailerpassword;
    
    
    public function __construct(MailerPassword $mailerpassword)
    
    {
        $this->mailerpassword =$mailerpassword;
    
    }
    public static function getSubscribedEvents () 
    
    {
        
        return [
            
            UserPasswordEvent::NAME=>'onUserPassword'
          //  UserSuccessPaymentEvent::NAME=>'onUserPayment'
            ];
    }
    
    
    public function onUserPassword(UserPasswordEvent $event)
    {
        
       $this->mailerpassword->SendEmailPassword($event->getChangedUserPassword());
        
    }
    
}
?>