<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\EntityRepository;

interface UserRepository extends EntityRepository
{
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
