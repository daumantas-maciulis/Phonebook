<?php
declare(strict_types=1);

namespace App\Tests;

use App\Entity\Phonebook;
use App\Entity\User;
use App\Model\PhonebookModel;
use App\Repository\PhonebookRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class PhonebookTest extends TestCase
{
    private function contactFromRequest(): \stdClass
    {
        $message = [
            "name" => "John",
            "lastName" => "Doe",
            "phoneNumber" => "+3706223323",
            "city" => "Vilnius",
            "adress" => "Verkiu 1"

        ];
        return (object)$message;
    }

    public function testAddNewUser()
    {
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $phonebookRepositoryMock = $this->createMock(PhonebookRepository::class);
        $phonebookModel = new PhonebookModel($entityManagerMock, $phonebookRepositoryMock);

        $user = $this->createMock(User::class)->setEmail('test@test.com');

        $responseFromModel = $phonebookModel->addNewContact($this->contactFromRequest(), $user);

        $this->assertClassHasAttribute('lastName', Phonebook::class);
    }
}
