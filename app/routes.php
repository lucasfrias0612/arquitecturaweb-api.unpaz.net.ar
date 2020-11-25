<?php
declare(strict_types=1);

use App\Application\Actions\Meeting\CreateMeetingAction;
use App\Application\Actions\Meeting\DeleteMeetingAction;
use App\Application\Actions\Meeting\ListMeetingsAction;
use App\Application\Actions\Meeting\UpdateMeetingAction;
use App\Application\Actions\Meeting\ViewMeetingAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\SignInUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('NO SE PUEDE ACCEDER A LA RAIZ');
        return $response;
    });

    $app->group('/v1/user', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
        $group->post('', CreateUserAction::class);
        $group->post('/signin', SignInUserAction::class);
    });

    $app->group('/v1/meeting', function (Group $group) {
        $group->get('', ListMeetingsAction::class);
        $group->get('/{id}', ViewMeetingAction::class);
        $group->post('', CreateMeetingAction::class);
        $group->patch('', UpdateMeetingAction::class);
        $group->delete('', DeleteMeetingAction::class);
    });

    $app->group('/v1/meeting/registration', function (Group $group) {
        $group->post('', RegisterAction::class);
        $group->delete('', UnregisterAction::class);
    });

    $app->get('/v1/test', function (Request $request, Response $response) {
        $db =new \App\Infrastructure\Persistence\PostgreSQL\PostgresqlConnection("host=db port=5432 dbname=arq-web user=lucasfrias password=example");
        $response->getBody()->write($db->executeSelectQuery("Select * from users"));
        return $response;
    });

};
