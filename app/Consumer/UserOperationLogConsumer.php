<?php
declare(strict_types=1);

namespace App\Consumer;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;


#[Process(name: "user-operation-log-queue")]
class UserOperationLogConsumer extends ConsumerProcess
{
    protected string $queue = 'user_operation_log';
}