<?php
declare(strict_types=1);

namespace App\Application\Actions\Meeting;

use Psr\Http\Message\ResponseInterface as Response;

class CreateMeetingAction extends MeetingAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->args = (array)$this->getFormData();
        $newMeeting =$this->resolveArgsAndConstructMeeting();
        $newMeeting->setId($this->repository->getLastId() + 1);
        $this->repository->insertMeeting($newMeeting);
        $this->logger->info("Meeting ".$newMeeting->toString()." was created.");

        return $this->respondWithData($this->repository->findAll());
    }
}