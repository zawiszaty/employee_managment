<?php

declare(strict_types=1);


namespace App\Module\Employee\UI\HTTP\REST;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonBodyParserSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isJsonRequest($request))
        {
            return;
        }

        $content = $request->getContent();

        if (empty($content))
        {
            return;
        }

        if (!$this->transformJsonBody($request))
        {
            $response = Response::create('Unable to parse json request.', 400);
            $event->setResponse($response);
        }
    }

    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    private function transformJsonBody(Request $request): bool
    {
        /** @var string $json */
        $json = $request->getContent();
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error())
        {
            return false;
        }

        if (null === $data)
        {
            return true;
        }

        $request->request->replace($data);

        return true;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}