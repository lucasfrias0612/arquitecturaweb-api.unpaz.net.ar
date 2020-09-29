<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use phpDocumentor\Reflection\Types\This;
use function DI\add;

class InFileUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users;

    private const DB_FILE_PATH = __DIR__ . '/users-db.json';

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [];
        $i = 1;
        foreach (json_decode(file_get_contents(self::DB_FILE_PATH, true)) as $user) {
            $this->users[$i] = new User((int)$user->{'id'},
                (string)$user->{'email'},
                (string)$user->{'password'},
                (string)$user->{'fullName'});
            $i++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    public function getLastId(): int
    {
        return count($this->users);
    }

    public function createUser(User $user)
    {
        array_push($this->users, $user);
        $this->persist();
    }

    public function authenticate($email, $password): string
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                if ($user->getPassword() === $password) {
                    return hash('sha256', $email . $password);
                }
            }
        }
        throw new UserNotFoundException();
    }

    private function persist()
    {
        $encodedString = json_encode($this->users);
        file_put_contents(self::DB_FILE_PATH, $encodedString);
    }
}
