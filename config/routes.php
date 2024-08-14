<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

/*---admin route begin---*/
Router::addGroup('/admin', function () {
    Router::post('/sessions', [App\Controller\Admin\SessionsController::class, 'create'], [
        'name' => 'login'
    ]);

    Router::addGroup('', function () {
        Router::delete('/sessions', [App\Controller\Admin\SessionsController::class, 'destroy']);
        Router::put('/sessions', [App\Controller\Admin\SessionsController::class, 'update']);
        Router::get('/me', [App\Controller\Admin\SessionsController::class, 'me']);

        Router::get('/users/{id}', [App\Controller\Admin\UsersController::class, 'show']);
        Router::get('/roles/{id}', [App\Controller\Admin\RolesController::class, 'show']);
        Router::get('/permissions/{id}', [App\Controller\Admin\PermissionsController::class, 'show']);

        Router::get('/all/roles', [App\Controller\Admin\RolesController::class, 'all']);
        Router::get('/all/permissions', [App\Controller\Admin\PermissionsController::class, 'all']);

        Router::get('/user/{id}/roles', [App\Controller\Admin\UsersController::class, 'roles']);
        Router::get('/role/{id}/permissions', [App\Controller\Admin\RolesController::class, 'permissions']);

        // 需要rbac鉴权部分
        Router::addGroup('', function () {
            Router::get('/users', [App\Controller\Admin\UsersController::class, 'list'], ['name' => 'userList']);
            Router::post('/users', [App\Controller\Admin\UsersController::class, 'create'], ['name' => 'userCreate']);
            Router::put('/users/{id}', [App\Controller\Admin\UsersController::class, 'update'], ['name' => 'userUpdate']);
            Router::delete('/users/{id}', [App\Controller\Admin\UsersController::class, 'destroy'], ['name' => 'userDestroy']);
            Router::put('/users/status/{id}', [App\Controller\Admin\UsersController::class, 'changeStatus'], ['name' => 'changeUserStatus']);

            Router::get('/roles', [App\Controller\Admin\RolesController::class, 'list'], ['name' => 'roleList']);
            Router::post('/roles', [App\Controller\Admin\RolesController::class, 'create'], ['name' => 'roleCreate']);
            Router::put('/roles/{id}', [App\Controller\Admin\RolesController::class, 'update'], ['name' => 'roleUpdate']);
            Router::delete('/roles/{id}', [App\Controller\Admin\RolesController::class, 'destroy'], ['name' => 'roleDestroy']);

            Router::get('/permissions', [App\Controller\Admin\PermissionsController::class, 'list'], ['name' => 'permissionList']);
            Router::post('/permissions', [App\Controller\Admin\PermissionsController::class, 'create'], ['name' => 'permissionCreate']);
            Router::put('/permissions/{id}', [App\Controller\Admin\PermissionsController::class, 'update'], ['name' => 'permissionUpdate']);
            Router::delete('/permissions/{id}', [App\Controller\Admin\PermissionsController::class, 'destroy'], ['name' => 'permissionDestroy']);

            Router::post('/syncRoleToUser', [App\Controller\Admin\RbacController::class, 'syncRoleToUser'], ['name' => 'syncRoleToUser']);
            Router::post('/syncPermissionToRole', [App\Controller\Admin\RbacController::class, 'syncPermissionToRole'], ['name' => 'syncPermissionToRole']);
        }, ['middleware' => [\App\Middleware\RbacMiddleware::class]]);
    }, ['middleware' => [Phper666\JWTAuth\Middleware\JWTAuthDefaultSceneMiddleware::class]]);
});
/*---admin route end---*/