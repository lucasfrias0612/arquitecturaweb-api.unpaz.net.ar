<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\PostgreSQL\User;

use App\Domain\Meeting\MeetingNotFoundException;
use App\Domain\User\IncorrectPasswordException;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\PostgreSQL\PostgresqlConnection;

class PostgresqlUserRepository implements UserRepository
{
    /**
     * @var PostgresqlConnection
     */
    private $conn;

    public function __construct(){
        $this->conn=new PostgresqlConnection("host=db port=5432 dbname=arq-web user=lucasfrias password=example");
    }

    public function getAll(): array
    {
        return $this->conn->executeSelectQuery("Select * from users");
    }

    public function getById(int $id)
    {
        $res=$this->conn->executeSelectQuery("Select * from users where id=".$id)[0];
        return new User((int)$res['id'],$res['email'],$res['password'],$res['fullName']);

    }

    public function getLastId(): int
    {
        $result=$this->conn->executeSelectQuery("Select id as lastid from users order by id desc limit 1")[0];
        if (!isset($result['lastid'])) {
            throw new MeetingNotFoundException();
        }
        return ((int)$result['lastid'])+1;
    }

    public function delete(int $id): bool
    {
        $toDelete=[];
        $user=$this->getById($id);
        $toDelete['id']=$user->getId();$toDelete['email']=$user->getEmail();
        $toDelete['password']=$user->getPassword();$toDelete['fullName']=$user->getTime();
        $dbconn = $this->conn->getConnection();
        $res = pg_delete($dbconn, 'users', $toDelete);
        if ($res) {
            return true;
        }
        return false;
    }

    public function createUser(User $newUser)
    {
        $toInsert=[];
        $toInsert['id']=$this->getLastId();$toInsert['email']=$newUser->getEmail();
        $toInsert['password']=$newUser->getPassword();$toInsert['fullName']=$newUser->getFullName();
        $dbconn = $this->conn->getConnection();
        $res = pg_insert($dbconn, 'users', $toInsert);
        if ($res) {
            return true;
        }
        return false;
    }

    public function authenticate($email, $password): string
    {
        foreach ($this->getAll() as $user) {
            if ($user['email'] === $email) {
                if ($user['password'] === $password) {
                    return hash('sha256', $email . $password);
                } else {
                    throw new IncorrectPasswordException();
                }
            }
        }
        throw new UserNotFoundException();
    }
}