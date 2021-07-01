<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Phonebook;
use App\Model\PhonebookModel;
use App\Service\SharedContactsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/api/v1/share")
 */
class SharedContactsController extends AbstractController
{
    /**
     * @Route(methods="POST")
     */
    public function shareContactAction(Request $request, SharedContactsService $contactsService): JsonResponse
    {
        $userRequest = $request->toArray();
        $responseFromService = $contactsService->shareContacts($userRequest, $this->getUser());

        if($responseFromService instanceof Phonebook) {
            return $this->response($responseFromService, Response::HTTP_CREATED);
        }

        return $this->response($responseFromService, Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route(methods="DELETE")
     */
    public function removeSharedContactAction(Request $request, PhonebookModel $phonebookModel): JsonResponse
    {
        $userRequest = $request->toArray();
        $responseFromModel = $phonebookModel->removeSharedContact($userRequest, $this->getUser());

        if($responseFromModel instanceof Phonebook) {
            return $this->response($responseFromModel, Response::HTTP_OK);
        }

        $message = [
            'error' => 'This contact is not shared with user'
        ];

        return $this->response($message, Response::HTTP_BAD_REQUEST);
    }

    private function response(array|Phonebook $responseMessage, int $responseCode): JsonResponse
    {
        return $this->json($responseMessage, $responseCode, [], [
            ObjectNormalizer::IGNORED_ATTRIBUTES  => ['owner', 'roles', 'password', 'username', 'salt', 'contacts', '__initializer__', '__cloner__', '__isInitialized__']
        ]);
    }
}

