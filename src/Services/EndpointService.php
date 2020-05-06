<?php

namespace App\Services;

use App\Type\EndpointResponseType;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EndpointService
 * @package App\Services
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class EndpointService
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * EndpointService constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function serialize(Request $request, Response $response): Response
    {
        $format = $request->query
                ->get('format') ?? EndpointResponseType::JSON;
        ;

        $format = in_array($format, [EndpointResponseType::XML, EndpointResponseType::JSON], true) ? $format : EndpointResponseType::JSON;

        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $responseDataArray = @unserialize($response->getContent());

        $serializedResponse = $this->serializer
            ->serialize($responseDataArray, $format, $context)
        ;

        $response->setContent($serializedResponse);

        return $response;
    }
}