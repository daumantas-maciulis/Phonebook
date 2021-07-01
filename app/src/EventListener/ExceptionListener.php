<?php
declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $exceptionResponse = $this->getExceptionResponse($exception);

        $event->setResponse($exceptionResponse);
    }

    private function getExceptionResponse(\Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->handleNotFoundHttpException();
        } else {
            $response = [
                'message' => 'Internal server error',
                'code' => 500
            ];
            return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function handleNotFoundHttpException(): JsonResponse
    {
        $response = [
            'message' => 'Not Found',
            'code' => 404
        ];

        return new JsonResponse($response, Response::HTTP_NOT_FOUND);
    }

}

