<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\InFile\Meeting;

use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingNotFoundException;
use App\Domain\Meeting\MeetingRepository;
use App\Infrastructure\Persistence\InFile\InFileRepository;

class InFileMeetingRepository extends InFileRepository implements MeetingRepository
{
    function createEntity($record)
    {
        $meeting=new Meeting((int)$record->{'userid'},
            (string)$record->{'title'},
            (string)$record->{'description'},
            (string)$record->{'time'});
        $meeting->setId((int)$record->{'id'});
        return $meeting;
    }

    /**
     * @throws MeetingNotFoundException
     */
    function throwDomainRecordNotFoundException()
    {
        throw new MeetingNotFoundException();
    }

    function getFilePath(): string
    {
        return __DIR__ . '/meetings-db.json';
    }

    public function insertMeeting(Meeting $newMeeting)
    {
        array_push($this->records, $newMeeting);
        $this->persist();
    }

    public function delete(int $id): bool
    {
        if(isset($this->records[$id])){
            unset($this->records[$id]);
            $this->persist();
            return true;
        }
        return false;
    }

    public function updateMeeting(int $meetingId, Meeting $newMeeting) : bool
    {
        if(isset($this->records[$meetingId])){
            $this->records[$meetingId]=$newMeeting;
            $this->persist();
            return true;
        }
        return false;
    }
}