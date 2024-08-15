<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\Admin\User;
use App\Producer\UserOperationLogProducer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zero0719\HyperfApi\Utils\CommonUtil;
use function Hyperf\Support\make;

class UserOperationLogMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = strtoupper($request->getMethod());

        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            // 丢进队列
            $user = User::getCurrentUserInfoFromContext();
            make(UserOperationLogProducer::class)->push([
                'user_id' => $user['id'],
                'url' => $request->getMethod() . ':' . $request->getUri()->getPath(),
                'data' => $request->getParsedBody(),
                'ip' => CommonUtil::getIp()
            ]);
        }

        return $handler->handle($request);
    }
}
