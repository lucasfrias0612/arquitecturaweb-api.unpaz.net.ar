<?php
declare(strict_types=1);

namespace App\Application\Actions\Meeting;

use App\Application\Actions\Action;
use App\Application\Actions\User\UserAction;
use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

abstract class MeetingAction extends Action
{
    /**
     * @var MeetingRepository
     */
    protected $repository;

    /**
     * @param LoggerInterface $logger
     * @param MeetingRepository $meetingRepository
     */
    public function __construct(LoggerInterface $logger, MeetingRepository $meetingRepository)
    {
        parent::__construct($logger);
        $this->repository = $meetingRepository;
    }

    /**campusportada
     * @throws HttpBadRequestException
     */
    protected function resolveArgsAndConstructMeeting(): Meeting
    {
        $title = $this->resolveArg('title');
        $description = $this->resolveArg('description');
        $time = $this->resolveArg('time');
        $userid = (int)$this->resolveArg('userId');
        return new Meeting($userid, $title, $description, $time);
    }

    /**
     * @param string $idArgName
     * @return Meeting
     * @throws HttpBadRequestException
     */
    protected function findMeetingOfId(string $idArgName): Meeting
    {
        $meetingId = (int)$this->resolveArg($idArgName);
        return $this->repository->getById($meetingId);
    }
}