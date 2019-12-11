<?php

namespace App\Listener;

use App\Services\EndpointService;
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
     * @var EndpointService
     */
    private $endpointService;

    /**
     * ResponseListener constructor.
     * @param EndpointService $endpointService
     */
    public function __construct(EndpointService $endpointService)
    {
        $this->endpointService = $endpointService;
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

        $response = $this->endpointService
            ->serialize($request, $response);

        $responseEvent->setResponse($response);

        return $responseEvent;
    }
}