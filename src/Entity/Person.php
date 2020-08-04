<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type={"int", "null"}, message="Mauvais format de données")
     * @Assert\Range(
     *      min= "1",
     *      max = "2",
     *      notInRangeMessage = "Le Genre n'est pas valide",
     * )
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\NotBlank(message="Le prénom ne doit pas être vide")
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Le Prénom doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\NotBlank(message="Le nom ne doit pas être vide")
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Le Nom doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\NotBlank(message="Le numéro de téléphone ne doit pas être vide")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\NotBlank(message="L'adresse ne doit pas être vide")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "L'adresse doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type={"int", "null"}, message="Mauvais format de données")
     * @Assert\Positive(message="Le Capital apporté ne peux pas être négatif")
     */
    private $capitalAmountAdding;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type(type={"bool", "null"}, message="Mauvais format de données")
     */
    private $hasCompany;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le domaine d'expertise doit contenir au maximum {{ limit }} characters"
     * )
     */
    private $specialization;

    // /**
    //  * @ORM\OneToOne(targetEntity=Company::class, mappedBy="president", cascade={"persist", "remove"})
    //  */
    // private $companies;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="myAssociates")
     */
    private $associates;

    /**
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="associates")
     */
    private $myAssociates;

    /**
     * @ORM\OneToMany(targetEntity=AssociateCompanyInfo::class, mappedBy="person")
     */
    private $associateCompanyInfos;

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="president")
     */
    private $companies;

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="generalDirector")
     */
    private $companiesGeneralDirector;

    public function __construct()
    {
        $this->myAssociates = new ArrayCollection();
        $this->associateCompanyInfos = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->companiesGeneralDirector = new ArrayCollection();
    }

    // /**
    //  * @ORM\ManyToMany(targetEntity=Person::class, inversedBy="associates")
    //  */
    // private $associates;

    // public function __construct()
    // {
    //     $this->associates = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
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

    public function getCapitalAmountAdding(): ?int
    {
        return $this->capitalAmountAdding;
    }

    public function setCapitalAmountAdding(?int $capitalAmountAdding): self
    {
        $this->capitalAmountAdding = $capitalAmountAdding;

        return $this;
    }

    public function getHasCompany(): ?bool
    {
        return $this->hasCompany;
    }

    public function setHasCompany(?bool $hasCompany): self
    {
        $this->hasCompany = $hasCompany;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(?string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function __toString()
    {
        //Les noms des champs à afficher dans l'éditeur de document.
        return "firstName,lastName,phoneNumber,address,country,capitalAmountAdding";
    }

    // public function getCompanies(): ?Company
    // {
    //     return $this->companies;
    // }

    // public function setCompanies(?Company $companies): self
    // {
    //     $this->companies = $companies;

    //     // set (or unset) the owning side of the relation if necessary
    //     $newPresident = null === $companies ? null : $this;
    //     if ($companies->getPresident() !== $newPresident) {
    //         $companies->setPresident($newPresident);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|self[]
    //  */
    // public function getAssociates(): Collection
    // {
    //     return $this->associates;
    // }

    // public function addAssociate(self $associate): self
    // {
    //     if (!$this->associates->contains($associate)) {
    //         $this->associates[] = $associate;
    //     }

    //     return $this;
    // }

    // public function removeAssociate(self $associate): self
    // {
    //     if ($this->associates->contains($associate)) {
    //         $this->associates->removeElement($associate);
    //     }

    //     return $this;
    // }

    public function getAssociates(): ?self
    {
        return $this->associates;
    }

    public function setAssociates(?self $associates): self
    {
        $this->associates = $associates;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMyAssociates(): Collection
    {
        return $this->myAssociates;
    }

    public function addMyAssociate(self $myAssociate): self
    {
        if (!$this->myAssociates->contains($myAssociate)) {
            $this->myAssociates[] = $myAssociate;
            $myAssociate->setAssociates($this);
        }

        return $this;
    }

    public function removeMyAssociate(self $myAssociate): self
    {
        if ($this->myAssociates->contains($myAssociate)) {
            $this->myAssociates->removeElement($myAssociate);
            // set the owning side to null (unless already changed)
            if ($myAssociate->getAssociates() === $this) {
                $myAssociate->setAssociates(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AssociateCompanyInfo[]
     */
    public function getAssociateCompanyInfos(): Collection
    {
        return $this->associateCompanyInfos;
    }

    public function addAssociateCompanyInfo(AssociateCompanyInfo $associateCompanyInfo): self
    {
        if (!$this->associateCompanyInfos->contains($associateCompanyInfo)) {
            $this->associateCompanyInfos[] = $associateCompanyInfo;
            $associateCompanyInfo->setPerson($this);
        }

        return $this;
    }

    public function removeAssociateCompanyInfo(AssociateCompanyInfo $associateCompanyInfo): self
    {
        if ($this->associateCompanyInfos->contains($associateCompanyInfo)) {
            $this->associateCompanyInfos->removeElement($associateCompanyInfo);
            // set the owning side to null (unless already changed)
            if ($associateCompanyInfo->getPerson() === $this) {
                $associateCompanyInfo->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setPresident($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getPresident() === $this) {
                $company->setPresident(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompaniesGeneralDirector(): Collection
    {
        return $this->companiesGeneralDirector;
    }

    public function addCompaniesGeneralDirector(Company $companiesGeneralDirector): self
    {
        if (!$this->companiesGeneralDirector->contains($companiesGeneralDirector)) {
            $this->companiesGeneralDirector[] = $companiesGeneralDirector;
            $companiesGeneralDirector->setGeneralDirector($this);
        }

        return $this;
    }

    public function removeCompaniesGeneralDirector(Company $companiesGeneralDirector): self
    {
        if ($this->companiesGeneralDirector->contains($companiesGeneralDirector)) {
            $this->companiesGeneralDirector->removeElement($companiesGeneralDirector);
            // set the owning side to null (unless already changed)
            if ($companiesGeneralDirector->getGeneralDirector() === $this) {
                $companiesGeneralDirector->setGeneralDirector(null);
            }
        }

        return $this;
    }
}
