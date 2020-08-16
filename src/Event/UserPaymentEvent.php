<?php
namespace App\Event;
use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\EventDispatcher\Event;

class UserPaymentEvent extends Event 

{

const NAME='user.payment';

/**
 * @var Person
 */
public function __construct (Person $paidUser) 
{
 $this->paidUser = $paidUser; 

}


/**
 * @return Person
 */
public function getpaidUser() : Person 
{
 return $this->paidUser;    
}




     
}
?>