<?php
declare(strict_types=1);

namespace App\Controller\Security;

use App\Model\UserModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/create-account", methods="POST")
     */
    public function createAccountAction(Request $request, UserModel $userModel): JsonResponse
    {
        $userInput = $request->toArray();
        $userExists = $userModel->checkIfExist($userInput['email']);
        if ($userExists) {
            $responseMessage = [
                'error' => sprintf('User with email %s already exist', $userInput['email'])
            ];

            return $this->json($responseMessage, Response::HTTP_BAD_REQUEST);
        }

        $userModel->createNewUser($userInput);

        return $this->json("Registration completed", Response::HTTP_CREATED);
    }
}

