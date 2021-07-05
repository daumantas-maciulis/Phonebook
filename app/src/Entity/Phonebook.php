<?php

namespace App\Entity;

use App\Repository\PhonebookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhonebookRepository::class)
 */
class Phonebook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contacts")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $sharedWith;

//    /**
//     * @ORM\ManyToOne(targetEntity=CityWeather::class)
//     */
//    private $city;



    public function __construct()
    {
        $this->sharedWith = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSharedWith(): Collection
    {
        return $this->sharedWith;
    }

    public function addSharedWith(User $sharedWith): self
    {
        if (!$this->sharedWith->contains($sharedWith)) {
            $this->sharedWith[] = $sharedWith;
        }

        return $this;
    }

    public function removeSharedWith(User $sharedWith): self
    {
        $this->sharedWith->removeElement($sharedWith);

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getCity()
    {
        return $this->city;
    }


    public function setCity($city): void
    {
        $this->city = $city;
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress($adress): void
    {
        $this->adress = $adress;
    }
}
