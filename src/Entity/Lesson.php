<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'lessonsContained')]
    #[ORM\JoinColumn(nullable:false)]

    private $containedIn;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'lessonsCreated')]
    #[ORM\JoinColumn(nullable:false)]
    private $Creatby;

    #[ORM\Column( type:'array', nullable: true)]
    private $ressources = [];

   

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

    public function getContainedIn(): ?Section
    {
        return $this->containedIn;
    }

    public function setContainedIn(?Section $scontainedIn): self
    {
        $this->containedIn = $scontainedIn;

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

    public function getRessources(): array
    {
        return $this->ressources;
    }

    public function setRessources(?array $ressources): self
    {
        $this->ressources = $ressources;

        return $this;
    }

    
}
