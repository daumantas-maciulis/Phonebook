<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\Phonebook;
use App\Repository\PhonebookRepository;
use Doctrine\ORM\EntityManagerInterface;

class PhonebookModel
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PhonebookRepository $phonebookRepository
    )
    {}

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

    public function addNewContact(array $contactFromRequest): Phonebook
    {
        $newContact = new Phonebook();

        $newContact->setName($contactFromRequest['name']);
        $newContact->setPhoneNumber($contactFromRequest['phoneNumber']);

        $this->saveData($newContact);

        return $newContact;
    }

    public function getAllContacts(): array
    {

        return $this->phonebookRepository->findAll();
    }

    public function getOneContact(string $id): Phonebook|null
    {
        $contact = $this->phonebookRepository->find($id);
        if($contact) {
            return $contact;
        }
        return null;
    }

    public function updateContact(array $contactInformation, string $id): Phonebook
    {
        $contact = $this->getOneContact($id);

        if ($contactInformation['phoneNumber']) {
            $contact->setPhoneNumber($contactInformation['phoneNumber']);
        }
        if($contactInformation['name']) {
            $contact->setName($contactInformation['name']);
        }

        $this->saveData($contact);

        return $contact;
    }

    public function deleteContact(string $id): bool
    {
        $contact = $this->phonebookRepository->find($id);

        if($contact != null) {
            $this->deleteData($contact);
            return true;
        }
        return false;
    }

}