<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Title;

    #[ORM\Column(type: 'text')]
    private $Description;


   
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'trainingsCreated')]
    private $Creatby;

 
    #[ORM\Column(type: 'date', nullable:true)]
    private $Datecreate;


    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\OneToMany(mappedBy: 'containedIn', targetEntity: Section::class)]
    private $sectionsContained;

    public function __construct()
    {
        $this->sectionsContained = new ArrayCollection();
        
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

  

    

    public function getCreatby(): ?user
    {
        return $this->Creatby;
    }

    public function setCreatby(?user $Creatby): self
    {
        $this->Creatby = $Creatby;

        return $this;
    }
   
     

  

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->Datecreate;
    }

    public function setDatecreate(\DateTimeInterface $Datecreate): self
    {
        $this->Datecreate = $Datecreate;

        return $this;
    }
    

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    
     public function getSectionsContained(): Collection
     {
         return $this->sectionsContained;

     }
 
     public function addSectionsContained(Section $sectionsContained): self
     {
         if (!$this->sectionsContained->contains($sectionsContained)) {
             $this->sectionsContained[] = $sectionsContained;
             $sectionsContained->setContainedIn($this);
         }
 
         return $this;
     }
 
     public function removeSectionsContained(Section $sectionsContained): self
     {
         if ($this->sectionsContained->removeElement($sectionsContained)) {
             // set the owning side to null (unless already changed)
             if ($sectionsContained->getContainedIn() === $this) {
                 $sectionsContained->setContainedIn(null);
             }
         }
 
         return $this;
     }
     public function __toString()
    {
        return $this->Title;
    }


    
}

