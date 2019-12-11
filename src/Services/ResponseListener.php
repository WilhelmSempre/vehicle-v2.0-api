<?php

namespace App\Services;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseListener
 * @package App\Services
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class ResponseListener
{

    /** @var SerializerInterface */
    private $serializer;

    /**
     * ResponseListener constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Response $response
     * @param Request $request
     * @return Response
     */
    public function serializeResponse(Response $response, Request $request): Response
    {
        $format = $request->query
            ->get('format') ?? 'json';

        $format = in_array($format, ['xml', 'json'], true) ? $format : 'json';

        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $responseDataArray = @unserialize($response->getContent());

        $serializedResponse = $this->serializer
            ->serialize($responseDataArray, $format, $context)
        ;

        $response->setContent($serializedResponse);

        return $response;
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

        $response = $this->serializeResponse($response, $request);

        $responseEvent->setResponse($response);

        return $responseEvent;
    }
}