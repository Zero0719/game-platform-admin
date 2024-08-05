<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Request\Admin\RolesRequest as AdminRolesRequest;
use App\Service\Admin\RolesService;
class RolesController extends BaseController
{
    /**
     * @var RolesService
     */
    protected RolesService $service;

    public function __construct(RolesService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        return $this->success($this->service->list());
    }
    
    public function create(AdminRolesRequest $request)
    {
        $this->service->create();

        return $this->success();
    }
    
    public function update(AdminRolesRequest $request)
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