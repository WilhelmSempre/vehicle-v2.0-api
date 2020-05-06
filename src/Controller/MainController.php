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
}
