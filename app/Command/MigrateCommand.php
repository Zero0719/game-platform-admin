<?php
declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;

#[Command]
class MigrateCommand extends HyperfCommand
{
    protected ?string $name = 'admin:migrate';
    
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'migrations/admin'
        ]);
    }
}