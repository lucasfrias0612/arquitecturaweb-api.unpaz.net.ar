<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\IncorrectPasswordException;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\InFileRepository;


class InFileUserRepository extends InFileRepository implements UserRepository
{
    public function createUser(User $user)
    {
        array_push($this->records, $user);
        $this->persist();
    }

    /**
     * @param $email
     * @param $password
     * @return string
     * @throws IncorrectPasswordException
     * @throws UserNotFoundException
     */
    public function authenticate($email, $password): string
    {
        foreach ($this->records as $user) {
            if ($user->getEmail() === $email) {
                if ($user->getPassword() === $password) {
                    return hash('sha256', $email . $password);
                } else {
                    throw new IncorrectPasswordException();
                }
            }
        }
        $this->throwDomainRecordNotFoundException();
    }

    function createEntity($record)
    {
        return new User((int)$record->{'id'},
            (string)$record->{'email'},
            (string)$record->{'password'},
            (string)$record->{'fullName'});
    }

    /**
     * @throws UserNotFoundException
     */
    function throwDomainRecordNotFoundException()
    {
        throw new UserNotFoundException();
    }

    function getFilePath(): string
    {
        return __DIR__ . '/users-db.json';
    }
}
