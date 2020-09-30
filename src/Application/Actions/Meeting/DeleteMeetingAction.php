<?php


namespace App\Application\Actions\Meeting;


use App\Application\Actions\User\UserAction;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteMeetingAction extends MeetingAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->args = (array)$this->getFormData();
        $meetingId = (int) $this->resolveArg('meetingId');
        $userId = (int) $this->resolveArg('userId');
        $data['message']="Meeting of id ${meetingId} was ";
        if($this->repository->deleteMeeting($meetingId)){
            $data['message'].="deleted by user with ID:".$userId;
            $this->logger->info($data['message']);
        }else{
            $data['message'].="not found.";
        }

        return $this->respondWithData($data);
    }
}