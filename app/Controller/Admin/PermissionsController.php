<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Request\Admin\PermissionsRequest as AdminPermissionsRequest;
use App\Service\Admin\PermissionsService;

class PermissionsController extends BaseController
{
    /**
     * @var PermissionsService
     */
    public PermissionsService $service;
    
    public function __construct(PermissionsService $service)
    {
        $this->service = $service;
    }
    
    public function list()
    {
        return $this->success($this->service->list());
    }

    public function create(AdminPermissionsRequest $request)
    {
        $this->service->create();
        return $this->success();
    }

    public function update(AdminPermissionsRequest $request)
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
}