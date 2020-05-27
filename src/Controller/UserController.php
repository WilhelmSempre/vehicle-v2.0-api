<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\User;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/user", name="user_")
 *
 * Class UserController
 * @package App\Controller
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class UserController extends AbstractController
{

    /**
     * @Route("/create", name="create", methods={"POST"})
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserService $userService
     * @return Response
     */
    public function createAction(Request $request, ValidatorInterface $validator, UserService $userService): Response
    {
        $result = new Result();

        $response = new Response();

        $result
            ->setStatus(Response::HTTP_OK)
            ->setMessage('')
        ;

        $response->setStatusCode(Response::HTTP_OK);

        if (!$request->get('password') ||
            !$request->get('email')) {

            $result
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage('No data provided!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $user = new User();

        $user->setPassword($request->get('password'))
            ->setEmail($request->get('email'))
        ;


        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $result
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage($errors)
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $isUser = $userService->isUser($user->getEmail());

        if ($isUser) {
            $result
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage('User email already exists!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $userResponse = $userService->createUser($user);

        if (!$userResponse) {
            $result
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setMessage('User cannot be added!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        return $response->setContent(serialize($result));
    }

    /**
     * @Route("/get/email/{email}", name="get_email", methods={"GET"})
     *
     * @param string $email
     * @param UserService $userService
     * @return Response
     */
    public function getAction(string $email, UserService $userService): Response
    {
        $response = new Response();

        $result = new Result();

        /** @var User $user */
        $user = $userService->getUserByEmail(urldecode($email));

        if (!$user) {
            $result
                ->setStatus(Response::HTTP_NOT_FOUND)
                ->setMessage('User not found!')
            ;

            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            return $response->setContent(serialize($result));
        }

        $user->setPassword('[HIDDEN VALUE]');

        return $response->setContent(serialize($user));
    }
}