<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\EntityRepository;

abstract class InFileRepository implements EntityRepository
{
    protected $records;

    /**
     * InFileRepository constructor.
     *
     * @param array|null $records
     */
    public function __construct(array $records = null)
    {
        $this->records = $records ?? [];
        $i = 1;
        foreach (json_decode(file_get_contents($this->getFilePath(), true)) as $record) {
            $this->records[$i] = $this->createEntity($record);
            $i++;
        }
    }

    public function findAll(): array
    {
        return array_values($this->records);
    }

    public function findOfId(int $id)
    {
        if (!isset($this->records[$id])) {
            $this->throwDomainRecordNotFoundException();
        }
        return $this->records[$id];
    }

    public function getLastId(): int
    {
        return count($this->records);
    }

    protected function persist()
    {
        $encodedString = json_encode($this->records);
        file_put_contents($this->getFilePath(), $encodedString);
    }

    /**
     * @param $record
     * @return mixed
     */
    abstract function createEntity($record);

    abstract function throwDomainRecordNotFoundException();

    abstract function getFilePath() : string;
}