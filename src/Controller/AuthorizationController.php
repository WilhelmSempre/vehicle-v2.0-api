<?php

namespace App\Controller;

use App\Entity\ApiAuthorization;
use App\Services\AuthorizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorizationController
 * @package App\Controller
 */
class AuthorizationController extends AbstractController
{
    /**
     * @Route("/authorize", name="authorization")
     *
     * @param Request $request
     * @param AuthorizationService $authorizationService
     * @return Response
     */
    public function authorizeClient(Request $request, AuthorizationService $authorizationService): Response
    {
        $isSecretValid = $authorizationService->isSecretValid($request);

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
