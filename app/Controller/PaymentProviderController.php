<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Admin\BaseController;
use App\Request\PaymentProviderRequest;
use App\Service\PaymentProviderService;

class PaymentProviderController extends BaseController
{
    protected PaymentProviderService $service;

    public function __construct(PaymentProviderService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        return $this->success($this->service->list());
    }

    public function create(PaymentProviderRequest $request)
    {
        $this->service->create();
        return $this->success();
    }

    public function update(PaymentProviderRequest $request)
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
}
