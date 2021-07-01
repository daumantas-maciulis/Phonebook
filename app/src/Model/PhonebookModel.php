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

    public function addNewContact(array $contactFromRequest, UserInterface $user): Phonebook
    {
        $newContact = new Phonebook();

        /** @var User $user */
        $newContact->setOwner($user);
        $newContact->setName($contactFromRequest['name']);
        $newContact->setPhoneNumber($contactFromRequest['phoneNumber']);

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

    public function getOneContact(string $id, UserInterface $user): Phonebook|null
    {
        $contact = $this->phonebookRepository->findOneBy(['id' => $id, 'owner' => $user]);
        if ($contact) {
            return $contact;
        }
        return null;
    }

    public function updateContact(array $contactInformation, string $id, UserInterface $user): Phonebook|null
    {
        $contact = $this->getOneContact($id, $user);

        if(!$contact) {
            return null;
        }

        if ($contactInformation['phoneNumber']) {
            $contact->setPhoneNumber($contactInformation['phoneNumber']);
        }
        if ($contactInformation['name']) {
            $contact->setName($contactInformation['name']);
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

}