<?php

namespace App\Entity;

use App\Repository\CompaniesTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompaniesTypesRepository::class)
 */
class CompaniesTypes
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
     * @ORM\OneToMany(targetEntity=AssociateCompanyInfo::class, mappedBy="companyType")
     */
    private $associateCompanyInfos;

    public function __construct()
    {
        $this->associateCompanyInfos = new ArrayCollection();
    }

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
            $associateCompanyInfo->setCompanyType($this);
        }

        return $this;
    }

    public function removeAssociateCompanyInfo(AssociateCompanyInfo $associateCompanyInfo): self
    {
        if ($this->associateCompanyInfos->contains($associateCompanyInfo)) {
            $this->associateCompanyInfos->removeElement($associateCompanyInfo);
            // set the owning side to null (unless already changed)
            if ($associateCompanyInfo->getCompanyType() === $this) {
                $associateCompanyInfo->setCompanyType(null);
            }
        }

        return $this;
    }
}
