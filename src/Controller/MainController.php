<?php

namespace App\Controller;

use App\Entity\ApiAuthorization;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class MainController extends AbstractController
{

    /**
     * @Route("/", name="main")
     */
    public function mainAction(): Response
    {
        return new Response();
    }

    /**
     * @Route("/authorize/{secret}", name="authorization")
     *
     * @param string $secret
     * @return Response
     */
    public function authorizeClient(string $secret): Response
    {
        $isSecretValid = $_ENV['APP_SECRET'] === $secret && $secret !== '';

        $apiAuthorization = new ApiAuthorization();

        $apiAuthorization
            ->setStatus(Response::HTTP_OK)
            ->setMessage('')
        ;

        if (!$isSecretValid) {
            $apiAuthorization
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage('Invalid secret key')
            ;
        }

        $respone = new Response();
        $respone->setContent(serialize($apiAuthorization));

        return $respone;
    }
}