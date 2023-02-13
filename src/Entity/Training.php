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


   
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'trainings')]
    private $Creatby;

 
    #[ORM\Column(type: 'date', nullable:true)]
    private $Datecreate;

    #[ORM\OneToMany(mappedBy: 'training', targetEntity: Section::class,orphanRemoval:true,cascade:['persist','remove'])]
    private $sections;

    #[ORM\ManyToOne(inversedBy: 'formation')]
    private ?Section $section = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
    

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        
        if (!$this->sections->contains($section)){
            $this->sections[] = $section;
            $section->setTraining($this);
            
        }
        
        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getTraining() === $this) {
                $section->setTraining(null);
            }
        }

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

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
}
