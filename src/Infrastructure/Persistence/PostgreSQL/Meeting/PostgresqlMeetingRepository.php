<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\PostgreSQL\Meeting;


use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\EntityRepository;
use App\Domain\Meeting\Meeting;
use App\Domain\Meeting\MeetingNotFoundException;
use App\Domain\Meeting\MeetingRepository;
use App\Infrastructure\Persistence\PostgreSQL\PostgresqlConnection;
use phpDocumentor\Reflection\Types\This;

class PostgresqlMeetingRepository implements MeetingRepository
{
    /**
     * @var PostgresqlConnection
     */
    private $conn;

    public function __construct(){
        $this->conn=new PostgresqlConnection("host=db port=5432 dbname=arq-web user=lucasfrias password=example");
    }

    public function getAll(): array
    {
        return $this->conn->executeSelectQuery("Select * from meetings");
    }

    public function getById(int $id)
    {
        $res=$this->conn->executeSelectQuery("Select * from meetings where id=".$id)[0];
        $meeting=new Meeting((int)$res['userId'],$res['title'],$res['description'],$res['time']);
        $meeting->setId((int)$res['id']);
        return $meeting;

    }

    public function getLastId(): int
    {
        $result=$this->conn->executeSelectQuery("Select id as lastid from meetings order by id desc limit 1")[0];
        if (!isset($result['lastid'])) {
            throw new MeetingNotFoundException();
        }
        return ((int)$result['lastid'])+1;
    }

    public function delete(int $id): bool
    {
        $toDelete=[];
        $meeting=$this->getById($id);
        $toDelete['userId']=$meeting->getUserId();
        $toDelete['title']=$meeting->getTitle();$toDelete['description']=$meeting->getDescription();
        $toDelete['time']=$meeting->getTime();
        $dbconn = $this->conn->getConnection();
        $res = pg_delete($dbconn, 'meetings', $toDelete);
        if ($res) {
            return true;
        }
        return false;
    }

    public function insertMeeting(Meeting $newMeeting)
    {
        $toInsert=[];
        $toInsert['id']=$this->getLastId();$toInsert['userId']=$newMeeting->getUserId();
        $toInsert['title']=$newMeeting->getTitle();$toInsert['description']=$newMeeting->getDescription();
        $toInsert['time']=$newMeeting->getTime();
        $dbconn = $this->conn->getConnection();
        $res = pg_insert($dbconn, 'meetings', $toInsert);
        if ($res) {
            return true;
        }
        return false;
    }

    public function updateMeeting(int $meetingId, Meeting $newMeeting): bool
    {
        $toUpdate=[];
        $condition = array('id'=>$meetingId);
        $toUpdate['userId']=$newMeeting->getUserId();
        $toUpdate['title']=$newMeeting->getTitle();$toUpdate['description']=$newMeeting->getDescription();
        $toUpdate['time']=$newMeeting->getTime();
        $dbconn = $this->conn->getConnection();
        $res = pg_update($dbconn, 'meetings', $toUpdate, $condition);
        if ($res) {
            return true;
        }
        return false;
    }
}