<?php
declare(strict_types=1);

namespace App\Listener;

use App\Services\ApiRequestService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    private ApiRequestService $apiRequestService;

    public function __construct(ApiRequestService $apiRequestService)
    {
        $this->apiRequestService = $apiRequestService;
    }

    public function listen(ResponseEvent $responseEvent): ResponseEvent
    {
        $response = $responseEvent->getResponse();
        $request = $responseEvent->getRequest();

        $response = $this->apiRequestService
            ->serialize($request, $response)
        ;

        $responseEvent->setResponse($response);

        return $responseEvent;
    }
}
