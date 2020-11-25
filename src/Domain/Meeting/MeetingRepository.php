<?php
declare(strict_types=1);

namespace App\Domain\Meeting;

use App\Domain\EntityRepository;

interface MeetingRepository extends EntityRepository
{
    public function insertMeeting(Meeting $newMeeting);

    public function updateMeeting(int $meetingId, Meeting $newMeeting): bool;
}