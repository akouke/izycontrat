<?php
namespace App\Event;
use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event 

{

const NAME='user.register';

/**
 * @var Person
 */
public function __construct (Person $registeredUser) 
{
 $this->registeredUser = $registeredUser;   
 
}


/**
 * @return Person
 */
public function getRegisteredUser() : Person 
{
 return $this->registeredUser;    
}



     
}
?>