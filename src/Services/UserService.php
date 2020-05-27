<?php


namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * Class UserService
 * @package App\Services
 *
 * @author Rafał Głuszak <rafal.gluszak@gmail.com>
 */
class UserService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @return bool
     */
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

    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): ?User
    {
        return $this->entityManager
            ->find(User::class, $id)
        ;
    }

    /**
     * @param string $email
     * @return object
     */
    public function getUserByEmail(string $email): ?object
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager
            ->getRepository(User::class);

        return $userRepository->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isUser(string $email): bool
    {
        $user = $this->getUserByEmail($email);

        if (!$user) {
            return false;
        }

        return true;
    }

    /**
     * @param array $credentials
     * @return bool
     */
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

        var_dump($user);

        return $credentials['password'] === $user->getPassword();
    }
}