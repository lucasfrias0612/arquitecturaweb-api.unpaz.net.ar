<?php
declare(strict_types=1);

use App\Domain\Meeting\MeetingRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\PostgreSQL\Meeting\PostgresqlMeetingRepository;
use App\Infrastructure\Persistence\PostgreSQL\User\PostgresqlUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(PostgresqlUserRepository::class),
        MeetingRepository::class => \DI\autowire(PostgresqlMeetingRepository::class)
    ]);
};
