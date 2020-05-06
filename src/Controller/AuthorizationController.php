<?php

namespace App\Controller;

use App\Entity\ApiAuthorization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorizationController
 * @package App\Controller
 */
class AuthorizationController extends AbstractController
{
    /**
     * @Route("/authorize/{secret}", name="authorization")
     *
     * @param string $secret
     * @return Response
     */
    public function authorizeClient(string $secret): Response
    {
        $isSecretValid = $_ENV['APP_SECRET'] === $secret;

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

        $response = new Response();
        $response->setContent(serialize($apiAuthorization));

        return $response;
    }
}
