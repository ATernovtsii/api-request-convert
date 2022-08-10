<?php

namespace tandrewcl\ApiRequestConvertBundle\EventListener;

use Symfony\Component\HttpFoundation\{Exception\JsonException};
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestTransformerListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        try {
            $request->request->replace($request->toArray());
        } catch (JsonException) {
        }
    }
}