<?php
declare(strict_types=1);

use App\Domain\Meeting\MeetingRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Meeting\InFileMeetingRepository;
use App\Infrastructure\Persistence\User\InFileUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InFileUserRepository::class),
        MeetingRepository::class => \DI\autowire(InFileMeetingRepository::class)
    ]);
};
