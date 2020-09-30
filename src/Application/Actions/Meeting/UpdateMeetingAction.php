<?php
declare(strict_types=1);

namespace App\Application\Actions\Meeting;

use Psr\Http\Message\ResponseInterface as Response;

class UpdateMeetingAction extends MeetingAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->args = (array)$this->getFormData();
        $meetingId=(int) $this->resolveArg('meetingId');
        $meetingData=$this->resolveArg('meetingData');
        $userId=$this->resolveArg('userId');
        $this->args = (array)$meetingData;
        $newMeeting =$this->resolveArgsAndConstructMeeting();
        $newMeeting->setId($meetingId);
        $this->repository->updateMeeting($meetingId, $newMeeting);
        $this->logger->info("Meeting ".$newMeeting->toString()." was updated by user with ID:".$userId.".");

        return $this->respondWithData($this->repository->findAll());
    }
}