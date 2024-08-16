<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Admin\Permission;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;

#[Command]
class PermissionGenerateCommand extends HyperfCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('admin:gen-permission');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('根据路由文件将权限写入后台数据');
    }

    public function handle()
    {
        $this->info('开始同步路由权限到后台数据');
        $factory = $this->container->get(\Hyperf\HttpServer\Router\DispatcherFactory::class);
        $router = $factory->getRouter('http');
        [$staticRouters, $variableRouters] = $router->getData();

        $permissions = [];
        foreach ($staticRouters as $items) {
            foreach ($items as $handler) {
                if (!isset($handler->options['flag'])) {
                    continue;
                }
                $options = $handler->options;
                $name = $options['name'] ? : $options['flag'];
                $permissions[$options['flag']] = $name;
            }
        }

        foreach ($variableRouters as $items) {
            foreach ($items as $item) {
                if (is_array($item['routeMap'] ?? false)) {
                    foreach ($item['routeMap'] as $routeMap) {
                        if (!isset($routeMap[0]->options['flag'])) {
                            continue;
                        }
                        $options = $routeMap[0]->options;
                        $name = $options['name'] ? : $options['flag'];
                        $permissions[$options['flag']] = $name;
                    }
                }
            }
        }

        foreach ($permissions as $flag => $name) {
            Permission::updateOrCreate([
                'name' => $name,
                'flag' => $flag
            ]);
        }
        $this->info('同步完成');
    }
}
