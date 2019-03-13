<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestListener
{
    /**
    * Convert the content of request from JSON to associative array.
    *
    * @param GetResponseEvent $event
    */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (in_array($request->getMethod(), ['PUT', 'POST'])) {
            $data = json_decode(
                $request->getContent(), 
                true
            );
            if (!$data)
                throw new BadRequestHttpException();
            
            $request->request->replace(
                is_array($data) ? $data : []
            );
        } else {
            return;
        }
    }
}
