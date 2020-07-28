<?php

namespace App\Entity;

use App\Repository\AssociateCompanyInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociateCompanyInfoRepository::class)
 */
class AssociateCompanyInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    // /**
    //  * @ORM\OneToOne(targetEntity=Person::class, cascade={"persist", "remove"})
    //  */
    // private $person;

    // /**
    //  * @ORM\OneToOne(targetEntity=CompaniesTypes::class, cascade={"persist", "remove"})
    //  */
    // private $companyType;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="associateCompanyInfos")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity=CompaniesTypes::class, inversedBy="associateCompanyInfos")
     */
    private $companyType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // public function getPerson(): ?Person
    // {
    //     return $this->person;
    // }

    // public function setPerson(?Person $person): self
    // {
    //     $this->person = $person;

    //     return $this;
    // }


    // public function getCompanyType(): ?CompaniesTypes
    // {
    //     return $this->companyType;
    // }

    // public function setCompanyType(?CompaniesTypes $companyType): self
    // {
    //     $this->companyType = $companyType;

    //     return $this;
    // }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getCompanyType(): ?CompaniesTypes
    {
        return $this->companyType;
    }

    public function setCompanyType(?CompaniesTypes $companyType): self
    {
        $this->companyType = $companyType;

        return $this;
    }
}
