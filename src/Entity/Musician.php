<?php

namespace App\Entity;

use App\Repository\MusicianRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicianRepository::class)]
class Musician extends User
{


    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Instrument::class, inversedBy: 'musicians')]
    private Collection $intruments;

    #[ORM\OneToMany(mappedBy: 'musician', targetEntity: Participant::class)]
    private Collection $participants;

    public function __construct()
    {
        $this->intruments = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Instrument>
     */
    public function getIntruments(): Collection
    {
        return $this->intruments;
    }

    public function addIntrument(Instrument $intrument): self
    {
        if (!$this->intruments->contains($intrument)) {
            $this->intruments->add($intrument);
        }

        return $this;
    }

    public function removeIntrument(Instrument $intrument): self
    {
        $this->intruments->removeElement($intrument);

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setMusician($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getMusician() === $this) {
                $participant->setMusician(null);
            }
        }

        return $this;
    }
}