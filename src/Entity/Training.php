<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 */
class Training
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $costs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="id_training")
     */
    private $Lesson;

    public function __construct()
    {
        $this->Lesson = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCosts(): ?string
    {
        return $this->costs;
    }

    public function setCosts(string $costs): self
    {
        $this->costs = $costs;

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function setLesson(string $Lesson): self
    {
        $this->duration = $Lesson;

        return $this;
    }
    public function getLesson(): Collection
    {
        return $this->Lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->Lesson->contains($lesson)) {
            $this->Lesson[] = $lesson;
            $lesson->setIdTraining($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->Lesson->contains($lesson)) {
            $this->Lesson->removeElement($lesson);
            // set the owning side to null (unless already changed)
            if ($lesson->getIdTraining() === $this) {
                $lesson->setIdTraining(null);
            }
        }

        return $this;
    }
}
