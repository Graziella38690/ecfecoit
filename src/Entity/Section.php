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

    

    #[ORM\OneToMany(mappedBy: 'containedIn', targetEntity: Lesson::class,)]
    private $lessonsContained;

    

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sectionsCreated')]
    #[ORM\JoinColumn(nullable:false)]
    private $Creatby;

    

    #[ORM\ManyToOne(targetEntity: Training::class,inversedBy: 'sectionsContained')]
    #[ORM\JoinColumn(nullable:false)]
    private $containedIn;

   

    public function __construct()
    {
       
      
        $this->lessonsContained = new ArrayCollection();
        
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

    public function getCreatby(): ?user
    {
        return $this->Creatby;
    }

    public function setCreatby(?User $Creatby): self
    {
        $this->Creatby = $Creatby;

        return $this;
    }

 
    public function getContainedIn(): ?Training
    {
        return $this->containedIn;
    }

    public function setContainedIn(?Training $containedIn): self
    {
        $this->containedIn = $containedIn;

        return $this;
    }

    

     /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessonsContained;
    }

    public function addLessonContained(Lesson $lessonsContained): self
    {
        if (!$this->lessonsContained->contains($lessonsContained)) {
            $this->lessonsContained[] = $lessonsContained;
            $lessonsContained->setContainedIn($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lessonsContained): self
    {
        if ($this->lessonsContained->removeElement($lessonsContained)) {
            // set the owning side to null (unless already changed)
            if ($lessonsContained->getContainedIn() === $this) {
                $lessonsContained->setContainedIn(null);
            }
        }

        return $this;
    }


        

   
   
   
}
