<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCreated;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $hasProtection;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $hasAssociate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasDirector;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $headOffice;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $capitalSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bankName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $associates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=Person::class, inversedBy="companies", cascade={"persist", "remove"})
     */
    private $president;

    /**
     * @ORM\OneToOne(targetEntity=Person::class, cascade={"persist", "remove"})
     */
    private $generalDirector;

    // /**
    //  * @ORM\OneToOne(targetEntity=ActivitySector::class, cascade={"persist", "remove"})
    //  */
    // private $activitySector;

    // /**
    //  * @ORM\OneToOne(targetEntity=Priority::class, cascade={"persist", "remove"})
    //  */
    // private $priority;

    /**
     * @ORM\ManyToOne(targetEntity=CompaniesTypes::class)
     */
    private $companyType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $regimeMicroEntreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tradeName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $manager;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressManager;

    /**
     * @ORM\ManyToOne(targetEntity=ActivitySector::class, inversedBy="companies")
     */
    private $activitySector;

    /**
     * @ORM\ManyToOne(targetEntity=Priority::class, inversedBy="companies")
     */
    private $priority;

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

    public function getIsCreated(): ?bool
    {
        return $this->isCreated;
    }

    public function setIsCreated(bool $isCreated): self
    {
        $this->isCreated = $isCreated;

        return $this;
    }

    public function getHasProtection(): ?string
    {
        return $this->hasProtection;
    }

    public function setHasProtection(?string $hasProtection): self
    {
        $this->hasProtection = $hasProtection;

        return $this;
    }
    
    // public function getBankName(): ?string
    // {
    //     return $this->bankName;
    // }

    // public function setBankName(?string $bankName): self
    // {
    //     $this->bankName = $bankName;

    //     return $this;
    // }

    public function getHasAssociate(): ?string
    {
        return $this->hasAssociate;
    }

    public function setHasAssociate(string $hasAssociate): self
    {
        $this->hasAssociate = $hasAssociate;

        return $this;
    }

    public function getHasDirector(): ?bool
    {
        return $this->hasDirector;
    }

    public function setHasDirector(bool $hasDirector): self
    {
        $this->hasDirector = $hasDirector;

        return $this;
    }

    public function getHeadOffice(): ?int
    {
        return $this->headOffice;
    }

    public function setHeadOffice(?int $headOffice): self
    {
        $this->headOffice = $headOffice;

        return $this;
    }

    public function getCapitalSocial(): ?string
    {
        return $this->capitalSocial;
    }

    public function setCapitalSocial(?string $capitalSocial): self
    {
        $this->capitalSocial = $capitalSocial;

        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(?string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getAssociates(): ?int
    {
        return $this->associates;
    }

    public function setAssociates(?int $associates): self
    {
        $this->associates = $associates;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPresident(): ?Person
    {
        return $this->president;
    }

    public function setPresident(?Person $president): self
    {
        $this->president = $president;

        return $this;
    }

    public function getGeneralDirector(): ?Person
    {
        return $this->generalDirector;
    }

    public function setGeneralDirector(?Person $generalDirector): self
    {
        $this->generalDirector = $generalDirector;

        return $this;
    }

    // public function getCompanyType(): ?CompanyType
    // {
    //     return $this->CompanyType;
    // }

    // public function setCompanyType(?CompanyType $CompanyType): self
    // {
    //     $this->CompanyType = $CompanyType;

    //     return $this;
    // }

    // public function getActivitySector(): ?ActivitySector
    // {
    //     return $this->activitySector;
    // }

    // public function setActivitySector(?ActivitySector $activitySector): self
    // {
    //     $this->activitySector = $activitySector;

    //     return $this;
    // }

    // public function getPriority(): ?Priority
    // {
    //     return $this->priority;
    // }

    // public function setPriority(?Priority $priority): self
    // {
    //     $this->priority = $priority;

    //     return $this;
    // }

    public function getCompanyType(): ?CompaniesTypes
    {
        return $this->companyType;
    }

    public function setCompanyType(?CompaniesTypes $companyType): self
    {
        $this->companyType = $companyType;

        return $this;
    }

    public function getRegimeMicroEntreprise(): ?bool
    {
        return $this->regimeMicroEntreprise;
    }

    public function setRegimeMicroEntreprise(?bool $regimeMicroEntreprise): self
    {
        $this->regimeMicroEntreprise = $regimeMicroEntreprise;

        return $this;
    }

    public function getTradeName(): ?string
    {
        return $this->tradeName;
    }

    public function setTradeName(?string $tradeName): self
    {
        $this->tradeName = $tradeName;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(?string $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getAddressManager(): ?string
    {
        return $this->addressManager;
    }

    public function setAddressManager(?string $addressManager): self
    {
        $this->addressManager = $addressManager;

        return $this;
    }

    public function getActivitySector(): ?ActivitySector
    {
        return $this->activitySector;
    }

    public function setActivitySector(?ActivitySector $activitySector): self
    {
        $this->activitySector = $activitySector;

        return $this;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
