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
            return $this->json($responseFromService, Response::HTTP_CREATED, [], [
                ObjectNormalizer::IGNORED_ATTRIBUTES => ['owner', 'roles', 'password', 'username', 'salt', 'contacts']
            ]);
        }

        return $this->json($responseFromService, Response::HTTP_BAD_REQUEST);

//        $responseFromService = $contactService->shareContact($userRequest, $this->getUser());
//        if($responseFromService instanceof SharedContacts) {
//
//            return $this->json($responseFromService, Response::HTTP_BAD_REQUEST);
//        }
//
//        return $this->json($responseFromService, Response::HTTP_CREATED, [], [
//            ObjectNormalizer::IGNORED_ATTRIBUTES => ['owner']
//        ]);
    }
}