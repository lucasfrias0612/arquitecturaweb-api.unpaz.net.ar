<?php
declare(strict_types=1);

namespace App\Application\Actions\Meeting;
use Psr\Http\Message\ResponseInterface as Response;

class ViewMeetingAction extends MeetingAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $meeting=$this->findMeetingOfId('id');
        $this->logger->info("Meeting of id `".$meeting->getId()."` was viewed.");

        return $this->respondWithData($meeting);
    }
}