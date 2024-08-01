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
    'http' => [
        \Zero0719\HyperfApi\Middleware\CorsMiddleware::class,
        \Zero0719\HyperfApi\Middleware\RequestLogMiddleware::class,
        \Hyperf\Validation\Middleware\ValidationMiddleware::class,
    ],
];
