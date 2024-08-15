<?php
declare(strict_types=1);

namespace App\Producer;

use App\Job\UserOperationLogJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class UserOperationLogProducer
{
    protected DriverInterface $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('user_operation_log');
    }

    public function push($params, int $delay = 0): bool
    {
        return $this->driver->push(new UserOperationLogJob($params), $delay);
    }
}