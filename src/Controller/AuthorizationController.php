<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Result;
use App\Services\AuthorizationService;
use SodiumException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{
    /**
     * @throws SodiumException
     */
    #[Route('/authorize', name: 'authorization', methods: ["POST"])]
    public function authorizeClient(Request $request, AuthorizationService $authorizationService): Response
    {
        $isSecretValid = $authorizationService->isSecretValid($request);

        $result = new Result();

        $response = new Response();

        $result
            ->setStatus((string) Response::HTTP_OK)
            ->setMessage('')
        ;

        $response->setStatusCode(Response::HTTP_OK);

        if (!$isSecretValid) {
            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage('Invalid secret key')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        return $response->setContent(serialize($result));
    }
}
