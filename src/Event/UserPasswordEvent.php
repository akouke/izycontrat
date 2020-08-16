<?php
namespace App\Event;
use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\EventDispatcher\Event;

class UserPasswordEvent extends Event 

{

const NAME='user.password';

/**
 * @var User
 */
public function __construct (User $changedUserPassword) 
{
 $this->changedUserPassword = $changedUserPassword; 
 
 
}


/**
 * @return User
 */
public function getChangedUserPassword() : User 
{
 return $this->changedUserPassword;    
}


     
}
?>