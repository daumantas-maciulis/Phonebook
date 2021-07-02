<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Phonebook;
use App\Model\PhonebookModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("api/v1/find")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("", methods="GET")
     */
    public function findContactByName(Request $request, PhonebookModel $phonebookModel): JsonResponse
    {
        $userInput = $request->toArray();
        $responseFromModel = $phonebookModel->findContactByName($userInput, $this->getUser());
        if(!$responseFromModel) {
            $message = [
                'error' => sprintf('You dont have user with name %s in your contacts', $userInput['name'])
            ];

            return $this->response($message, Response::HTTP_BAD_REQUEST);
        }

        return $this->response($responseFromModel, Response::HTTP_OK);
    }

    private function response(array|Phonebook $responseMessage, int $responseCode): JsonResponse
    {
        return $this->json($responseMessage, $responseCode, [], [
            ObjectNormalizer::IGNORED_ATTRIBUTES  => ['owner', 'roles', 'password', 'username', 'salt', 'contacts', '__initializer__', '__cloner__', '__isInitialized__']
        ]);
    }
}