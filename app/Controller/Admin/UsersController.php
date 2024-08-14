<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Request\Admin\UsersRequest as AdminUsersRequest;
use App\Service\Admin\UsersService;

class UsersController extends BaseController
{
    /**
     * @var UsersService
     */
    protected $service;
    
    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }
    
    public function list()
    {
        return $this->success($this->service->list());
    }

    public function create(AdminUsersRequest $request)
    {
        $this->service->create();

        return $this->success();
    }

    public function update(AdminUsersRequest $request)
    {
        $this->service->update();
        return $this->success();
    }
    
    public function destroy(AdminUsersRequest $request)
    {
        $this->service->destroy();
        return $this->success();
    }
    
    public function show()
    {
        return $this->success($this->service->show());
    }

    public function changeStatus()
    {
        $this->service->changeStatus();
        return $this->success();
    }

    public function roles()
    {
        return $this->success($this->service->roles());
    }
}