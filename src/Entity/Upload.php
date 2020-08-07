<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 * @Vich\Uploadable
 */
class Upload
{
    const MAX_SIZE="2000k";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @Vich\UploadableField(mapping="status_file", fileNameProperty="status")
     * @var File|null
     * @Assert\File(maxSize = Upload::MAX_SIZE,
     *     maxSizeMessage="Le fichier est trop gros  ({{ size }} {{ suffix }}),
     * il ne doit pas dépasser {{ limit }} {{ suffix }}",
     *     mimeTypes = {"application/pdf", "application/x-pdf", "application/odt", "application/doc",
     * "application/docx", "application/txt"},
     *     mimeTypesMessage = "Veuillez entrer un type de fichier valide: PDF.")
     */
    private $statusFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="uploads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime|null
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function setStatusFile(File $status = null)
    {
        $this->statusFile = $status;
        if ($status) {
            $this->updatedAt = new DateTime('now');
        }
    }

    public function getStatusFile(): ?File
    {
        return $this->statusFile;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
