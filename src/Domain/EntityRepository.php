<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\DomainException\DomainRecordNotFoundException;

interface EntityRepository
{
    public function getAll(): array;

    /**
     * @param int $id
     * @throws DomainRecordNotFoundException
     */
    public function getById(int $id);

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @return int
     */
    public function getLastId(): int;

}