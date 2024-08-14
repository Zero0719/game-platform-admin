## 后台项目雏形

项目以 `hyperf` 作为后端, `vue-admin-template` 作为前端模板，实现了基于 `rbac` 的控制权限模型。

## 环境

* php8.1
* swoole 5.x
* hyperf 3.x
* xmlwriter 扩展 (如果需要用到excel等内容)
* composer
* npm

## 安装

```bash
git clone https://github.com/Zero0719/admin-project.git
```

```bash
cd admin-project

composer install

php bin/hyperf.php admin:install

php bin/hyperf.php start
```

另起终端

```php
cd admin-project/public/vue-admin-template

npm install

# 如果有需要，请修改 .env.xxxx 中的 VUE_APP_BASE_API，该常量为后端 http 地址
npm run dev
```

## 权限控制

`routes.php` 文件中 `admin` 组分为三部分，一部分是不需要登录就可以访问，比如登录接口，一种是需要登录，但是不需要校验权限，另外一种则是需要登录并且校验权限，具体请查看该文件

## 实操

新增一个日志列表

`Admin/LogController.php`

控制器建议继承 `BaseController`

```php
<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class LogController extends BaseController 
{
    public function index() 
    {
        $data = [
            ['id' => 1, 'info' => '日志1'],
            ['id' => 2, 'info' => '日志2'],
            ['id' => 3, 'info' => '日志3'],
            ['id' => 4, 'info' => '日志4'],
        ];
        
        return $this->success($data);
    }
    
    public function show() 
    {
        return $this->success([
            'id' => 1,
            'info' => '日志1'
        ]);    
    }
}
```

`routes.php`

在需要登录但是不需要鉴权中添加

```php
Router::get('/logs/{id}', ['App\Controller\Admin\LogController', 'show']);
```

登录且授权中添加，需要注意路由要命名，这个值和 `admin_permissions` 中的 `flag` 一致
```php
Router::get('/logs', ['App\Controller\Admin\LogController', 'index'], ['name' => 'logIndex']);
```

前端添加路由，`permission` 决定了是否有权限渲染路由

```js
{
    path: '/logs',
    name: 'Logs',
    component: () => import('@/views/logs/index'),
    meta: { title: '日志列表', permission: 'logIndex' }
}
```

在后台权限面板中添加相应的权限 `logIndex`，并给角色授权等

## 其他

`admin.php` 中可配置白名单用户或者白名单角色
