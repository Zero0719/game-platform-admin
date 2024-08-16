<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Admin\BaseController;
use App\Service\PaymentService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class PaymentController extends BaseController
{
    protected PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->raw('Hello Hyperf!');
    }

    public function getPayPlatform()
    {
        return $this->success($this->service->getPayPlatform());
    }

    public function getPayType()
    {
        return $this->success($this->service->getPayType());
    }
}
