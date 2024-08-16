<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Admin\BaseController;
use App\Request\GameRequest;
use App\Service\GameService;

class GamesController extends BaseController
{
    protected GameService $service;

    public function __construct(GameService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        return $this->success($this->service->list());
    }

    public function create(GameRequest $request)
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
}
