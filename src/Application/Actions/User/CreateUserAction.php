<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    protected function action(): Response
    {
        $this->args = (array)$this->getFormData();
        $name = $this->resolveArg('fullName');
        $email = $this->resolveArg('email');
        $password = $this->resolveArg('password');
        $id = $this->userRepository->getLastId() + 1;
        $newUser = new User($id, $email, $password, $name);
        $this->userRepository->createUser($newUser);
        $this->logger->info("User [`${id}`,`${email}`,`${password}`,`${name}`] was created.");

        return $this->respondWithData($this->userRepository->findAll());
    }
}
