<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Phonebook;
use App\Model\CityWeatherModel;
use App\Model\PhonebookModel;
use App\Repository\CityWeatherRepository;
use App\Repository\PhonebookRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ContactsWithWeatherService
{
    private array $contactsWithWeatherArray = [];

    public function __construct(
        private PhonebookModel $phonebookModel,
        private CityWeatherModel $cityWeatherModel
    )
    {
    }

    public function returnContactsWithWeather(UserInterface $user): array
    {
        $userContacts = $this->phonebookModel->getAllContacts($user);
        foreach ($userContacts as $contact) {
            /** @var Phonebook $contact */
            $contactCity = $contact->getCity();
            $weatherInformation = $this->cityWeatherModel->getCityTemperature($contactCity);

            if($weatherInformation === null) {
                $contactWithWeather = [
                    'Contact Information' => $contact,
                    'Weather' => "City's weather information currently unavailable"
                ];

                $this->addContactToArray($contactWithWeather);
            }

            $contactWithWeather = [
                'Contact information' => $contact,
                'Weather' => $weatherInformation
            ];

            $this->addContactToArray($contactWithWeather);
        }

        return $this->contactsWithWeatherArray;
    }

    private function addContactToArray(array $contact): void
    {
        array_push($this->contactsWithWeatherArray, $contact);
    }
}