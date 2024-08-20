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

        Router::get('/logs/{id}', [App\Controller\Admin\LogsController::class, 'show']);

        Router::get('/all/games', [App\Controller\GamesController::class, 'all']);
        Router::get('/games/{id}', [App\Controller\GamesController::class, 'show']);

        Router::get('/paymentProviders/{id}', [App\Controller\PaymentProviderController::class, 'show']);
        Router::get('/all/paymentProviders', [App\Controller\PaymentProviderController::class, 'all']);

        Router::get('/payments/{id}', [App\Controller\PaymentController::class, 'show']);
        Router::get('/all/payments', [App\Controller\PaymentController::class, 'all']);
        Router::get('/paymentTypes', [App\Controller\PaymentController::class, 'paymentTypes']);

        // 需要rbac鉴权部分
        Router::addGroup('', function () {
            Router::get('/logs', [App\Controller\Admin\LogsController::class, 'list'], ['name' => '日志列表', 'flag' => 'logList']);

            Router::get('/users', [App\Controller\Admin\UsersController::class, 'list'], ['name' => '用户列表', 'flag' => 'userList']);
            Router::post('/users', [App\Controller\Admin\UsersController::class, 'create'], ['name' => '创建用户', 'flag' => 'userCreate']);
            Router::put('/users/{id}', [App\Controller\Admin\UsersController::class, 'update'], ['name' => '更新用户', 'flag' => 'userUpdate']);
            Router::delete('/users/{id}', [App\Controller\Admin\UsersController::class, 'destroy'], ['name' => '删除用户', 'flag' => 'userDestroy']);
            Router::put('/users/status/{id}', [App\Controller\Admin\UsersController::class, 'changeStatus'], ['name' => '修改用户状态', 'flag' => 'changeUserStatus']);

            Router::get('/roles', [App\Controller\Admin\RolesController::class, 'list'], ['name' => '角色列表', 'flag' => 'roleList']);
            Router::post('/roles', [App\Controller\Admin\RolesController::class, 'create'], ['name' => '创建角色', 'flag' => 'roleCreate']);
            Router::put('/roles/{id}', [App\Controller\Admin\RolesController::class, 'update'], ['name' => '更新角色', 'flag' => 'roleUpdate']);
            Router::delete('/roles/{id}', [App\Controller\Admin\RolesController::class, 'destroy'], ['name' => '删除角色','flag' => 'roleDestroy']);

            Router::get('/permissions', [App\Controller\Admin\PermissionsController::class, 'list'], ['name' => '权限列表', 'flag' => 'permissionList']);
            Router::post('/permissions', [App\Controller\Admin\PermissionsController::class, 'create'], ['name' => '创建权限', 'flag' => 'permissionCreate']);
            Router::put('/permissions/{id}', [App\Controller\Admin\PermissionsController::class, 'update'], ['name' => '更新权限', 'flag' => 'permissionUpdate']);
            Router::delete('/permissions/{id}', [App\Controller\Admin\PermissionsController::class, 'destroy'], ['name' => '删除权限', 'flag' => 'permissionDestroy']);

            Router::post('/syncRoleToUser', [App\Controller\Admin\RbacController::class, 'syncRoleToUser'], ['name' => '同步角色到用户', 'flag' => 'syncRoleToUser']);
            Router::post('/syncPermissionToRole', [App\Controller\Admin\RbacController::class, 'syncPermissionToRole'], ['name' => '同步权限到角色', 'flag' => 'syncPermissionToRole']);

            Router::get('/games', [App\Controller\GamesController::class, 'list'], ['name' => '游戏列表', 'flag' => 'gameList']);
            Router::post('/games', [App\Controller\GamesController::class, 'create'], ['name' => '创建游戏', 'flag' => 'gameCreate']);
            Router::put('/games/{id}', [App\Controller\GamesController::class, 'update'], ['name' => '更新游戏', 'flag' => 'gameUpdate']);
            Router::delete('/games/{id}', [App\Controller\GamesController::class, 'destroy'], ['name' => '删除游戏', 'flag' => 'gameDestroy']);

            Router::get('/paymentProviders', [App\Controller\PaymentProviderController::class, 'list'], ['name' => '支付商列表', 'flag' => 'paymentProviderList']);
            Router::post('/paymentProviders', [App\Controller\PaymentProviderController::class, 'create'], ['name' => '添加支付商', 'flag' => 'paymentProviderCreate']);
            Router::put('/paymentProviders/{id}', [App\Controller\PaymentProviderController::class, 'update'], ['name' => '更新支付商', 'flag' => 'paymentProviderUpdate']);
            Router::delete('/paymentProviders/{id}', [App\Controller\PaymentProviderController::class, 'destroy'], ['name' => '删除支付商', 'flag' => 'paymentProviderDestroy']);

            Router::get('/payments', [App\Controller\PaymentController::class, 'list'], ['name' => '支付方式列表', 'flag' => 'paymentList']);
            Router::post('/payments', [App\Controller\PaymentController::class, 'create'], ['name' => '添加支付方式', 'flag' => 'paymentCreate']);
            Router::put('/payments/{id}', [App\Controller\PaymentController::class, 'update'], ['name' => '更新支付方式', 'flag' => 'paymentUpdate']);
            Router::delete('/payments/{id}', [App\Controller\PaymentController::class, 'destroy'], ['name' => '删除支付方式', 'flag' => 'paymentDestroy']);
        }, ['middleware' => [\App\Middleware\RbacMiddleware::class, \App\Middleware\UserOperationLogMiddleware::class]]);
    }, ['middleware' => [Phper666\JWTAuth\Middleware\JWTAuthDefaultSceneMiddleware::class]]);
});
/*---admin route end---*/