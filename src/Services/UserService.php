<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class UserService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUser(User $user): bool
    {
        $this->entityManager->persist($user);

        try {
            $this->entityManager->flush();
        } catch (ORMException $exception) {
            return false;
        }

        return true;
    }

    public function getUserById(int $id): ?User
    {
        return $this->entityManager
            ->find(User::class, $id)
        ;
    }

    public function getUserByEmail(string $email): ?object
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager
            ->getRepository(User::class);

        return $userRepository->findOneBy([
            'email' => $email,
        ]);
    }

    public function isUser(string $email): bool
    {
        $user = $this->getUserByEmail($email);

        if (!$user) {
            return false;
        }

        return true;
    }

    public function login(array $credentials): bool
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager
            ->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository->findOneBy([
            'email' => $credentials['email'],
        ]);

        if (!$user) {
            return false;
        }

        return $credentials['password'] === $user->getPassword();
    }
}
