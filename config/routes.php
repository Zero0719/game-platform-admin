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
    Router::post('/sessions', [Zero0719\HyperfAdmin\Controller\SessionsController::class, 'create'], [
        'name' => 'login'
    ]);

    Router::addGroup('', function () {
        Router::delete('/sessions', [Zero0719\HyperfAdmin\Controller\SessionsController::class, 'destroy']);
        Router::put('/sessions', [Zero0719\HyperfAdmin\Controller\SessionsController::class, 'update']);
        Router::get('/me', [Zero0719\HyperfAdmin\Controller\SessionsController::class, 'me']);

        Router::get('/users/{id}', [Zero0719\HyperfAdmin\Controller\AdminUsersController::class, 'show']);
        Router::get('/roles/{id}', [Zero0719\HyperfAdmin\Controller\AdminRolesController::class, 'show']);
        Router::get('/permissions/{id}', [Zero0719\HyperfAdmin\Controller\AdminPermissionsController::class, 'show']);

        // 需要rbac鉴权部分
        Router::addGroup('', function () {
            Router::get('/users', [Zero0719\HyperfAdmin\Controller\AdminUsersController::class, 'list'], ['name' => 'userList']);
            Router::post('/users', [Zero0719\HyperfAdmin\Controller\AdminUsersController::class, 'create'], ['name' => 'userCreate']);
            Router::put('/users/{id}', [Zero0719\HyperfAdmin\Controller\AdminUsersController::class, 'update'], ['name' => 'userUpdate']);
            Router::delete('/users/{id}', [Zero0719\HyperfAdmin\Controller\AdminUsersController::class, 'destroy'], ['name' => 'userDestroy']);

            Router::get('/roles', [Zero0719\HyperfAdmin\Controller\AdminRolesController::class, 'list'], ['name' => 'roleList']);
            Router::post('/roles', [Zero0719\HyperfAdmin\Controller\AdminRolesController::class, 'create'], ['name' => 'roleCreate']);
            Router::put('/roles/{id}', [Zero0719\HyperfAdmin\Controller\AdminRolesController::class, 'update'], ['name' => 'roleUpdate']);
            Router::delete('/roles/{id}', [Zero0719\HyperfAdmin\Controller\AdminRolesController::class, 'destroy'], ['name' => 'roleDestroy']);

            Router::get('/permissions', [Zero0719\HyperfAdmin\Controller\AdminPermissionsController::class, 'list'], ['name' => 'permissionList']);
            Router::post('/permissions', [Zero0719\HyperfAdmin\Controller\AdminPermissionsController::class, 'create'], ['name' => 'permissionCreate']);
            Router::put('/permissions/{id}', [Zero0719\HyperfAdmin\Controller\AdminPermissionsController::class, 'update'], ['name' => 'permissionUpdate']);
            Router::delete('/permissions/{id}', [Zero0719\HyperfAdmin\Controller\AdminPermissionsController::class, 'destroy'], ['name' => 'permissionDestroy']);

            Router::post('/syncRoleToUser', [Zero0719\HyperfAdmin\Controller\RbacController::class, 'syncRoleToUser'], ['name' => 'syncRoleToUser']);
            Router::post('/syncPermissionToRole', [Zero0719\HyperfAdmin\Controller\RbacController::class, 'syncPermissionToRole'], ['name' => 'syncPermissionToRole']);
        }, ['middleware' => [\Zero0719\HyperfAdmin\Middleware\RbacMiddleware::class]]);
    }, ['middleware' => [Phper666\JWTAuth\Middleware\JWTAuthDefaultSceneMiddleware::class]]);
});
/*---admin route end---*/