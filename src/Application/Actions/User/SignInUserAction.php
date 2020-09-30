<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class SignInUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->args = (array)$this->getFormData();
        $email = $this->resolveArg('email');
        $password = $this->resolveArg('password');

        $token = array('token' => $this->repository->authenticate($email, $password));

        $this->logger->info("User `${email}` singed in.");

        return $this->respondWithData($token);
    }
}
