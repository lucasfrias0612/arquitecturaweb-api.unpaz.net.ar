<?php
declare(strict_types=1);

namespace App\Domain;

interface EntityRepository
{
    public function findAll(): array;

    /**
     * @param int $id
     * @throws DomainRecordNotFoundException
     */
    public function findOfId(int $id);

    /**
     * @return int
     */
    public function getLastId(): int;

}