<?php 

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        
        if ($exception instanceof BadRequestHttpException) {
            $response = new JsonResponse([
                'message' => 'Invalid JSON request.'
            ], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        } elseif ($exception instanceof NotFoundHttpException) {
            $response = new JsonResponse([
                'message' => 'Resource Not Found.'
            ], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof UniqueConstraintViolationException) {
            $response = new JsonResponse([
                'message' => 'Email already exists.'
            ], Response::HTTP_CONFLICT);
        } else {
            $response = new JsonResponse([
                'message' => 'The API cannot not process the request.'
            ], Response::HTTP_BAD_REQUEST);
        }
        
        // $event->setResponse($response);
    }
}
