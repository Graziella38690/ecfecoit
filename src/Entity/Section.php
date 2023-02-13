<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Title;

    

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Lesson::class,orphanRemoval:true)]
    private $lessons;

    #[ORM\ManyToOne(targetEntity: Training::class, inversedBy: 'sections')]
   
    private $training;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sections')]
    private $Creatby;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: training::class)]
    private Collection $trainings;

   

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
      
        $this->lessons = new ArrayCollection();
        
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

    

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setSection($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getSection() === $this) {
                $lesson->setSection(null);
            }
        }

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getCreatby(): ?user
    {
        return $this->Creatby;
    }

    public function setCreatby(?User $Creatby): self
    {
        $this->Creatby = $Creatby;

        return $this;
    }

 
    
        


    /**
     * @return Collection<int, training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addFormation(training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setSection($this);
        }

        return $this;
    }

    public function removeTraining(training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getSection() === $this) {
                $training->setSection(null);
            }
        }

        return $this;
    }
   
   
}
