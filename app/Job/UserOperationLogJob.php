<?php
declare(strict_types=1);

namespace App\Job;

use App\Model\Admin\Log;
use Hyperf\AsyncQueue\Job;

class UserOperationLogJob extends Job
{
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        if (!isset($this->params['user_id'])) {
            return;
        }

        Log::create([
            'user_id' => $this->params['user_id'],
            'url' => $this->params['url'],
            'data' => is_array($this->params['data']) ? json_encode($this->params['data']) : $this->params['data'],
            'ip' => $this->params['ip'],
            'created_at' => time()
        ]);
    }
}