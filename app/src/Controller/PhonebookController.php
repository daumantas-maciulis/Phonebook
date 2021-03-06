<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Phonebook;
use App\Model\CityWeatherModel;
use App\Model\PhonebookModel;
use App\Service\CityWeatherService;
use App\Service\ContactsWithWeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/api/v1/phonebook")
 */
class PhonebookController extends AbstractController
{
    /**
     * @Route(methods="POST")
     */
    public function createNewContactAction(Request $request, PhonebookModel $phonebookModel, CityWeatherModel $cityWeatherModel): JsonResponse
    {

        $userRequest = json_decode(json_encode($request->toArray()));

        $savedContact = $phonebookModel->addNewContact($userRequest, $this->getUser());
        if(isset($userRequest->city)) {
            $cityWeatherModel->addNewCity($userRequest->city);
        }

        return $this->response($savedContact, Response::HTTP_CREATED);
    }

    /**
     * @Route(methods="GET")
     */
    public function getAllContactsAction(PhonebookModel $phonebookModel, ContactsWithWeatherService $service): JsonResponse
    {
        $userContacts = $phonebookModel->getAllContacts($this->getUser());

        $userContactsWithWeather = $service->returnContactsWithWeather($this->getUser());

        $sharedContacts = $phonebookModel->getAllSharedContacts($this->getUser());

        if (!$userContacts) {
            $responseMessage = [
                'error' => 'You do not have any contacts'
            ];

            return $this->response($responseMessage, Response::HTTP_BAD_REQUEST);
        }

        $contacts = [
            'Your contacts' => $userContactsWithWeather,
            'Shared contacts' => $sharedContacts
        ];

        return $this->response($contacts, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods="GET")
     */
    public function getOneContactAction($id, PhonebookModel $phonebookModel): JsonResponse
    {
        $userContact = $phonebookModel->getOneContact($id, $this->getUser());

        if(!$userContact) {
            $responseMessage = [
                'error' => sprintf("Phonebook Id No. %s non exist or does not belong to you", $id)
            ];

            return $this->response($responseMessage, Response::HTTP_BAD_REQUEST);
        }
        return $this->response($userContact, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods="PUT")
     */
    public function updateContactAction($id, Request $request, PhonebookModel $phonebookModel): JsonResponse
    {
        $userRequest = json_decode(json_encode($request->toArray()));

        $updatedContact = $phonebookModel->updateContact($userRequest, $id, $this->getUser());

        if(!$updatedContact) {
            $responseMessage = [
                'error' => sprintf("Phonebook Id No. %s non exist or does not belong to you", $id)
            ];

            return $this->response($responseMessage, Response::HTTP_BAD_REQUEST);
        }
        return $this->response($updatedContact, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function deleteContactAction($id, PhonebookModel $phonebookModel): JsonResponse
    {
        $responseFromModel = $phonebookModel->deleteContact($id, $this->getUser());
        if ($responseFromModel === false) {
            $responseMessage = sprintf("Selected contact Id No. %s is not valid", $id);
            return $this->json($responseMessage, Response::HTTP_BAD_REQUEST);
        }
        $responseMessage = sprintf("Your contact Id No. %s was successfully deleted", $id);

        return $this->json($responseMessage, Response::HTTP_OK);
    }


    private function response(array|Phonebook $responseMessage, int $responseCode): JsonResponse
    {
        return $this->json($responseMessage, $responseCode, [], [
            ObjectNormalizer::IGNORED_ATTRIBUTES  => ['owner', 'roles', 'password', 'username', 'salt', 'contacts', '__initializer__', '__cloner__', '__isInitialized__']
        ]);
    }
}

