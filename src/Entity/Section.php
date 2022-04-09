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

    #[ORM\OneToMany(mappedBy: 'Section', targetEntity: Training::class)]
    private $trainings;

    #[ORM\OneToMany(mappedBy: 'Lesson', targetEntity: Lesson::class)]
    private $Lesson;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
        $this->Lesson = new ArrayCollection();
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
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setSection($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getSection() === $this) {
                $training->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLesson(): Collection
    {
        return $this->Lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->Lesson->contains($lesson)) {
            $this->Lesson[] = $lesson;
            $lesson->setLesson($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->Lesson->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getLesson() === $this) {
                $lesson->setLesson(null);
            }
        }

        return $this;
    }
}
