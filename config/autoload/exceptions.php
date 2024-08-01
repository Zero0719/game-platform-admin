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
return [
    'handler' => [
        'http' => [
            \Zero0719\HyperfApi\Exception\Handler\ValidationExceptionHandler::class,
            \Zero0719\HyperfApi\Exception\Handler\JWTExceptionHandler::class,
            \Zero0719\HyperfApi\Exception\Handler\ModelNotFoundExceptionHandler::class,
            \Zero0719\HyperfApi\Exception\Handler\BusinessExceptionHandler::class,
            \Zero0719\HyperfApi\Exception\Handler\AppExceptionHandler::class,
            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            App\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
