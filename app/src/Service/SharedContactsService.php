<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Phonebook;
use App\Model\PhonebookModel;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class SharedContactsService
{
    public function __construct(
        private PhonebookModel $phonebookModel,
        private UserRepository $userRepository
    )
    {
    }

    public function shareContacts(array $userRequest, UserInterface $user)
    {
        $contact = $this->phonebookModel->getOneContact($userRequest['contactId'], $user);
        if (!$contact) {
            return [
                'error' => sprintf("Phonebook Id No. %s non exist or does not belong to you", $userRequest['contactId'])
            ];
        }
        $userToShareWith = $this->userRepository->findOneBy(['email' => $userRequest['shareWith']]);
        if (!$userToShareWith) {
            return [
                'error' => sprintf("User %s non exist.", $userRequest['shareWith'])
            ];
        }

        return $this->phonebookModel->addSharedContact($contact, $userToShareWith);
    }

}
