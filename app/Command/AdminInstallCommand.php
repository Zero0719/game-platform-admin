<?php
declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\DbConnection\Db;
use App\Model\Admin\Permission as AdminPermissions;
use App\Model\Admin\Role as AdminRoles;
use App\Model\Admin\User;

#[Command]
class AdminInstallCommand extends HyperfCommand
{
    protected ?string $name = 'admin:install';
    public function handle()
    {
        $this->call('vendor:publish', [
            'package' => 'phper666/jwt-auth'
        ]);
        
        $this->call('vendor:publish', [
            'package' => 'zero0719/hyperf-api'
        ]);

        if (!Db::getSchemaBuilder()->hasTable('admin_users')) {
            $this->call('admin:migrate');
        };

        if (User::count() > 0) {
            $answer = $this->ask('已有用户数据，需要重装吗?[y/n]');
            
            if ($answer != 'y') {
                return $this->error('取消执行');
            }

            // 清空表
            User::truncate();
            AdminRoles::truncate();
            AdminPermissions::truncate();
        }

        while (true) {
            $username = $this->ask('请输入管理员用户名:');

            if (strlen($username) < 5) {
                $this->error('用户名长度不能小于5');
                continue;
            }
            break;
        }

        while (true) {
            $password = $this->ask('请输入管理员密码:');

            if (strlen($password) < 5) {
                $this->error('密码长度不能小于5');
                continue;
            }
            break;
        }

        if (!User::create([
            'username' => $username,
            'password' => $password
        ])) {
            return $this->error('创建管理员失败');
        }

        $this->info(sprintf('系统用户已创建, 用户名: %s, 密码: %s', $username, $password), 'success');

        // 生成初始权限
        $now = date('Y-m-d H:i:s');
        $permissions = [
            ['name' => '日志列表', 'flag' => 'logList', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '用户列表', 'flag' => 'userList', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '创建用户', 'flag' => 'userCreate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '更新用户', 'flag' => 'userUpdate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '删除用户', 'flag' => 'userDestroy', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '角色列表', 'flag' => 'roleList', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '创建角色', 'flag' => 'roleCreate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '更新角色', 'flag' => 'roleUpdate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '删除角色', 'flag' => 'roleDestroy', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '权限列表', 'flag' => 'permissionList', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '创建权限', 'flag' => 'permissionCreate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '更新权限', 'flag' => 'permissionUpdate', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '删除权限', 'flag' => 'permissionDestroy', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '同步角色到用户', 'flag' => 'syncRoleToUser', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '同步权限到角色', 'flag' => 'syncPermissionToRole', 'created_at' => $now, 'updated_at' => $now],
        ];

        AdminPermissions::insert($permissions);
        $this->info('权限列表初始化完成.');

        $this->info('系统安装成功.');
    }
}