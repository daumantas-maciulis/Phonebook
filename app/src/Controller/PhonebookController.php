<?php
declare(strict_types=1);

namespace App\Controller;


use App\Model\PhonebookModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/phonebook")
 */
class PhonebookController extends AbstractController
{
    /**
     * @Route(methods="POST")
     */
    public function createNerContactAction(Request $request, PhonebookModel $phonebookModel): JsonResponse
    {
        $savedContact = $phonebookModel->addNewContact($request->toArray());

        return $this->json($savedContact, Response::HTTP_CREATED);
    }

    /**
     * @Route(methods="GET")
     */
    public function getAllContactsAction(PhonebookModel $phonebookModel): JsonResponse
    {
        $userContacts = $phonebookModel->getAllContacts();

        return $this->json($userContacts, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods="GET")
     */
    public function getOneContactAction($id, PhonebookModel $phonebookModel): JsonResponse
    {
        $userContact = $phonebookModel->getOneContact($id);

        return $this->json($userContact, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods="PUT")
     */
    public function updateContactAction($id, Request $request, PhonebookModel $phonebookModel): JsonResponse
    {
        $updatedContact = $phonebookModel->updateContact($request->toArray(), $id);

        return $this->json($updatedContact, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function deleteContactAction($id, PhonebookModel $phonebookModel): JsonResponse
    {
        $responseFromModel = $phonebookModel->deleteContact($id);
        if($responseFromModel === false) {
            $responseMessage = sprintf("Selected contact Id No. %s is not valid", $id);
            return $this->json($responseMessage, Response::HTTP_BAD_REQUEST);
        }
        $responseMessage = sprintf("Your contact Id No. %s was successfully deleted", $id);

        return $this->json($responseMessage, Response::HTTP_OK);
    }
}

