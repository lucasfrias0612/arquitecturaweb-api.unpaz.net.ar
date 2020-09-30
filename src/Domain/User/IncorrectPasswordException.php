<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\DomainRecordNotFoundException;

class IncorrectPasswordException extends DomainRecordNotFoundException
{
    public $message = 'La contraseña ingresada no es correcta.';
}