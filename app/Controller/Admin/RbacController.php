<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\Admin\RbacService;
class RbacController extends BaseController
{
    /**
     * @var RbacService
     */
    protected RbacService $service;

    public function __construct(RbacService $service)
    {
        $this->service = $service;
    }

    public function syncRoleToUser()
    {
        $this->service->syncRoleToUser();
        return $this->success();
    }

    public function syncPermissionToRole()
    {
        $this->service->syncPermissionToRole();
        return $this->success();
    }
}