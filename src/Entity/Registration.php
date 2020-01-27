<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 */
class Registration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="Registration")
     */
    private $id_person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="Registration")
     */
    private $lesson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getIdPerson(): ?Person
    {
        return $this->id_person;
    }

    public function setIdPerson(?Person $id_person): self
    {
        $this->id_person = $id_person;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
}
