<?php

namespace App\Controller;

use App\Entity\Result;
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
     * @Route("/authorize", name="authorization", methods={"POST"})
     *
     * @param Request $request
     * @param AuthorizationService $authorizationService
     * @return Response
     */
    public function authorizeClient(Request $request, AuthorizationService $authorizationService): Response
    {
        $isSecretValid = $authorizationService->isSecretValid($request);

        $result = new Result();

        $response = new Response();

        $result
            ->setStatus(Response::HTTP_OK)
            ->setMessage('')
        ;

        $response->setStatusCode(Response::HTTP_OK);

        if (!$isSecretValid) {
            $result
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage('Invalid secret key')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $response->setContent(serialize($result));
    }
}
