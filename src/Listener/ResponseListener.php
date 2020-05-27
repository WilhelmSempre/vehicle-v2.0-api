<?php

namespace App\Listener;

use App\Services\ApiRequestService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseListener
 * @package App\Listener
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class ResponseListener
{

    /**
     * @var ApiRequestService
     */
    private ApiRequestService $apiRequestService;

    /**
     * ResponseListener constructor.
     * @param ApiRequestService $apiRequestService
     */
    public function __construct(ApiRequestService $apiRequestService)
    {
        $this->apiRequestService = $apiRequestService;
    }

    /**
     * @param ResponseEvent $responseEvent
     * @return ResponseEvent
     */
    public function listen(ResponseEvent $responseEvent): ResponseEvent
    {
        $response = $responseEvent->getResponse();
        $request = $responseEvent->getRequest();

        if (!$response) {
            return $responseEvent;
        }

        $response = $this->apiRequestService
            ->serialize($request, $response)
        ;

        $responseEvent->setResponse($response);

        return $responseEvent;
    }
}