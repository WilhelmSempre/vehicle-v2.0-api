<?php

namespace App\Services;

use App\Type\ApiResponseType;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiRequestService
 * @package App\Services
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class ApiRequestService
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ApiRequestService constructor.
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
                ->get('format') ?? ApiResponseType::JSON;
        ;

        $format = in_array($format, [ApiResponseType::XML, ApiResponseType::JSON], true) ? $format : ApiResponseType::JSON;

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