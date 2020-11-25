<?php
declare(strict_types=1);

namespace App\Application\Actions\Meeting;

use Psr\Http\Message\ResponseInterface as Response;

class ListMeetingsAction extends MeetingAction
{

    protected function action(): Response
    {
        $meetings = $this->repository->getAll();

        $this->logger->info("Meetings list was viewed.");

        return $this->respondWithData($meetings);
    }
}