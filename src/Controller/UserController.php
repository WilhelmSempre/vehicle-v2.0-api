<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Result;
use App\Entity\User;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function createAction(Request $request, ValidatorInterface $validator, UserService $userService): Response
    {
        $result = new Result();

        $response = new Response();

        $result
            ->setStatus((string) Response::HTTP_OK)
            ->setMessage('')
        ;

        $response->setStatusCode(Response::HTTP_OK);

        if (!$request->get('password') ||
            !$request->get('email')) {

            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
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
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage((string) $errors)
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $isUser = $userService->isUser($user->getEmail());

        if ($isUser) {
            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage('User email already exists!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $userResponse = $userService->createUser($user);

        if (!$userResponse) {
            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage('User cannot be added!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        return $response->setContent(serialize($result));
    }

    #[Route('/get/email/{email}', name: 'get_email')]
    public function getAction(string $email, UserService $userService): Response
    {
        $response = new Response();

        $result = new Result();

        /** @var User $user */
        $user = $userService->getUserByEmail(urldecode($email));

        if (!$user) {
            $result
                ->setStatus((string) Response::HTTP_NOT_FOUND)
                ->setMessage('User not found!')
            ;

            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            return $response->setContent(serialize($result));
        }

        $user->setPassword(null);

        return $response->setContent(serialize($user));
    }

    #[Route('/login', name: 'login')]
    public function loginAction(Request $request, UserService $userService): Response
    {
        $response = new Response();

        $result = new Result();

        $result
            ->setStatus((string) Response::HTTP_OK)
            ->setMessage('')
        ;

        $response->setStatusCode(Response::HTTP_OK);

        if (!$request->get('password') ||
            !$request->get('email')) {

            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage('No data provided!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];

        $loginUser = $userService->login($credentials);

        if (!$loginUser) {
            $result
                ->setStatus((string) Response::HTTP_FORBIDDEN)
                ->setMessage('Invalid email or password!')
            ;

            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            return $response->setContent(serialize($result));
        }

        return $response;
    }
}
