<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Admin\BaseController;
use App\Service\PaymentService;

class PaymentController extends BaseController
{
    protected PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        return $this->success($this->service->list());
    }

    public function create()
    {
        $this->service->create();
        return $this->success();
    }

    public function update()
    {
        $this->service->update();
        return $this->success();
    }

    public function destroy()
    {
        $this->service->destroy();
        return $this->success();
    }

    public function show()
    {
        return $this->success($this->service->show());
    }

    public function all()
    {
        return $this->success($this->service->all());
    }

    public function paymentTypes()
    {
        return $this->success($this->service->paymentTypes());
    }
}
