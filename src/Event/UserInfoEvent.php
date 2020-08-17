<?php
namespace App\Event;
use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\EventDispatcher\Event;

class UserInfoEvent extends Event 

{

const NAME='user.info';

/**
 * @var Person
 */
public function __construct (Person $connexionUserInfo) 
{
 $this->connexionUserInfo = $connexionUserInfo; 
 
 
}


/**
 * @return Person
 */
public function getConnexionUserInfo() : Person
{
 return $this->connexionUserInfo;    
}


     
}
?>