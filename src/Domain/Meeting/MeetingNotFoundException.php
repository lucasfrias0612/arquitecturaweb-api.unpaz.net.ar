<?php
declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\DomainException\DomainRecordNotFoundException;

class MeetingNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'La reunión solicitada NO existe.';
}
