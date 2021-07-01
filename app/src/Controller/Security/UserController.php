<?php


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
        $userModel->createNewUser($request->toArray());

        return $this->json("Registration completed", Response::HTTP_CREATED);
    }
}