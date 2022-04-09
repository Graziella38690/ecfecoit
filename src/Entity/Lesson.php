<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Title;

    #[ORM\Column(type: 'text')]
    private $textlesson;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'Lesson')]
    private $Lesson;

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

    public function getTextlesson(): ?string
    {
        return $this->textlesson;
    }

    public function setTextlesson(string $textlesson): self
    {
        $this->textlesson = $textlesson;

        return $this;
    }

    public function getLesson(): ?Section
    {
        return $this->Lesson;
    }

    public function setLesson(?Section $Lesson): self
    {
        $this->Lesson = $Lesson;

        return $this;
    }
}
