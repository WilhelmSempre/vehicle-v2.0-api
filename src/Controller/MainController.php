<?php

namespace App\Controller;

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

        if (!$isSecretValid) {
            return new JsonResponse([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Invalid secret key',
            ], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'message' => '',
        ], Response::HTTP_OK);
    }
}