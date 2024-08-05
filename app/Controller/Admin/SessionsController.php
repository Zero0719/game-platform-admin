<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\HttpServer\Contract\RequestInterface;
use App\Request\Admin\SessionsRequest;
use App\Service\Admin\SessionsService;
use Zero0719\HyperfApi\Controller\BaseController;

class SessionsController extends BaseController
{
    /**
     * @var SessionsService
     */
    protected SessionsService $service;
    
    public function __construct(SessionsService $service)
    {
        $this->service = $service;
    }
    
    public function create(SessionsRequest $request)
    {
        return $this->success($this->service->create());
    }

    public function destroy()
    {
        $this->service->destroy();
        return $this->success();
    }

    public function update(RequestInterface $request)
    {
        return $this->success($this->service->update());
    }
    
    public function me()
    {
        return $this->success($this->service->me());
    }
}