<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $Firstname;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $Lastname;

    #[ORM\Column(type: 'text', nullable: true)]
    private $specialities;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $Pseudo;

    #[ORM\OneToMany(mappedBy: 'Creatby', targetEntity: Training::class)]
    private $trainingsCreated;

    #[ORM\Column(type: 'datetime_immutable', options:['default' => 'CURRENT_TIMESTAMP'])]
    private $Dateinscription;

    #[ORM\OneToMany(mappedBy: 'Creatby', targetEntity: Lesson::class)]
    private $lessonsCreated;

    #[ORM\OneToMany(mappedBy: 'Creatby', targetEntity: Section::class)]
    private $sectionsCreated;


    #[ORM\Column]
    private ?bool $isValidated = false;

    public function __construct()
    {
        $this->trainingsCreated = new ArrayCollection();
        $this->lessonsCreated = new ArrayCollection();
        $this->sectionsCreated = new ArrayCollection();
        $this->Dateinscription = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = '';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(?string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(?string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getSpecialities(): ?string
    {
        return $this->specialities;
    }

    public function setSpecialities(?string $specialities): self
    {
        $this->specialities = $specialities;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(?string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainingsCreated;
    }

    public function addTrainingCreated(Training $trainingCreated): self
    {
        if (!$this->trainingsCreated->contains($trainingCreated)) {
            $this->trainingsCreated[] = $trainingCreated;
            $trainingCreated->setCreatby($this);
        }

        return $this;
    }

    public function removeTraining(Training $trainingsCreated): self
    {
        if ($this->trainingsCreated->removeElement($trainingsCreated)) {
            // set the owning side to null (unless already changed)
            if ($trainingsCreated->getCreatby() === $this) {
                $trainingsCreated->setCreatby(null);
            }
        }

        return $this;
    }

    public function getDateinscription(): ?\DateTimeImmutable
    {
        return $this->Dateinscription;
    }

    public function setDateinscription(\DateTimeImmutable $Dateinscription): self
    {
        $this->Dateinscription = $Dateinscription;

        return $this;
    }

    

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessonsCreated(): Collection
    {
        return $this->lessonsCreated;
    }

    public function addLesson(Lesson $lessonCreated): self
    {
        if (!$this->lessonsCreated->contains($lessonCreated)) {
            $this->lessonsCreated[] = $lessonCreated;
            $lessonCreated->setCreatby($this);
        }

        return $this;
    }

    public function removeLessonCreated(Lesson $lessonCreated): self
    {
        if ($this->lessonsCreated->removeElement($lessonCreated)) {
            // set the owning side to null (unless already changed)
            if ($lessonCreated->getCreatby() === $this) {
                $lessonCreated->setCreatby(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSectionsCreated(): Collection
    {
        return $this->getSectionsCreated();
    }

    public function addSectionsCreated(Section $sectionsCreated): self
    {
        if (!$this->sectionsCreated->contains($sectionsCreated)) {
            $this->sectionsCreated[] = $sectionsCreated;
            $sectionsCreated->setCreatby($this);
        }

        return $this;
    }

    public function removeSectionsCreated(Section $sectionsCreated): self
    {
        if ($this->sectionsCreated->removeElement($sectionsCreated)) {
            // set the owning side to null (unless already changed)
            if ($sectionsCreated->getCreatby() === $this) {
                $sectionsCreated->setCreatby(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->email;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    
}
