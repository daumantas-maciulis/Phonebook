<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\Phonebook;
use App\Entity\User;
use App\Repository\PhonebookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PhonebookModel
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PhonebookRepository $phonebookRepository
    )
    {
    }

    private function saveData(Phonebook $newContact): void
    {
        $this->entityManager->persist($newContact);
        $this->entityManager->flush();
    }

    private function deleteData(?Phonebook $contact): void
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();
    }

    public function addNewContact(\stdClass $contactFromRequest, UserInterface $user): Phonebook
    {
        $newContact = new Phonebook();

        /** @var User $user */
        $newContact->setOwner($user);
        $newContact->setName($contactFromRequest->name);
        $newContact->setPhoneNumber($contactFromRequest->phoneNumber);
        if (isset($contactFromRequest->phoneNumber)) {
            $newContact->setLastName($contactFromRequest->phoneNumber);
        }
        if (isset($contactFromRequest->city)) {
            $newContact->setCity($contactFromRequest->city);
        }
        if (isset($contactFromRequest->adress)) {
            $newContact->setAdress($contactFromRequest->adress);
        }


        $this->saveData($newContact);

        return $newContact;
    }

    public function getAllContacts(UserInterface $user): array|null
    {
        $userContacts = $this->phonebookRepository->findBy(['owner' => $user]);
        if (!$userContacts) {
            return null;
        }
        return $userContacts;
    }

    public function getAllSharedContacts(UserInterface $user): array
    {
        $sharedContactsArray = [];
        /** @var User $user */
        $sharedContacts = $this->phonebookRepository->findAll();
        foreach ($sharedContacts as $sharedContact) {
            $sharedWith = $sharedContact->getSharedWith()->contains($user);
            if ($sharedWith === true) {
                array_push($sharedContactsArray, $sharedContact);
            }
        }
        return $sharedContactsArray;
    }

    public function getOneContact(string $id, UserInterface $user): Phonebook|null
    {
        $contact = $this->phonebookRepository->findOneBy(['id' => $id, 'owner' => $user]);
        if ($contact) {
            return $contact;
        }
        return null;
    }

    public function updateContact(\stdClass $contactInformation, string $id, UserInterface $user): Phonebook|null
    {
        $contact = $this->getOneContact($id, $user);

        if (!$contact) {
            return null;
        }
        if (isset($contactInformation->name)) {
            $contact->setName($contactInformation->name);
        }
        if (isset($contactInformation->phoneNumber)) {
            $contact->setPhoneNumber($contactInformation->phoneNumber);
        }
        if (isset($contactInformation->lastName)) {
            $contact->setLastName($contactInformation->lastName);
        }
        if (isset($contactInformation->city)) {
            $contact->setCity($contactInformation->city);
        }
        if (isset($contactInformation->adress)) {
            $contact->setAdress($contactInformation->adress);
        }

        $this->saveData($contact);

        return $contact;
    }

    public function deleteContact(string $id, UserInterface $user): bool
    {
        $contact = $this->phonebookRepository->findOneBy(['id' => $id, 'owner' => $user]);

        if ($contact != null) {
            $this->deleteData($contact);
            return true;
        }
        return false;
    }

    public function addSharedContact(Phonebook $phonebook, UserInterface $userToShareWith): Phonebook
    {
        /** @var User $userToShareWith */
        $phonebook->addSharedWith($userToShareWith);

        $this->saveData($phonebook);

        return $phonebook;
    }

    public function removeSharedContact(array $userRequest, UserInterface $user): Phonebook|null
    {
        $sharedContact = $this->getOneContact($userRequest['contactId'], $user);
        if (!$sharedContact) {
            return null;
        }

        $contactsSharedWith = $sharedContact->getSharedWith()->toArray();

        foreach ($contactsSharedWith as $sharedWith) {
            /** @var User $sharedWith */
            if ($sharedWith->getEmail() === $userRequest['shareWith']) {
                $sharedContact->removeSharedWith($sharedWith);

                $this->saveData($sharedContact);

                return $sharedContact;
            }
        }
        return null;
    }

    public function findContactByName(array $userInput, UserInterface $user): array|null
    {
        $contact = $this->phonebookRepository->findBy(['name' => $userInput['name'], 'owner' => $user]);
        if (!$contact) {
            return null;
        }

        return $contact;
    }

}
