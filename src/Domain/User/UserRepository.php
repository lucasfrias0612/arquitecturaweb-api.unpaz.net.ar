<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id);

    /**
     * @return int
     */
    public function getLastId(): int;

    /**
     * @param User $user
     * @return mixed
     */
    public function createUser(User $user);

    /**
     * @param $email
     * @param $password
     * @return string
     * @throws UserNotFoundException
     */
    public function authenticate($email, $password): string;
}
