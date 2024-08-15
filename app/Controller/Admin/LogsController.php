<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Admin\Log;
use App\Service\Admin\LogsService;

class LogsController extends BaseController
{
    /**
     * @var LogsService
     */
    protected LogsService $service;

    public function __construct(LogsService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        return $this->success($this->service->list());
    }

    public function show()
    {
        return $this->success($this->service->show());
    }
}