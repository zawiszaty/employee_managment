<?php

declare(strict_types=1);

namespace App\module\Employee\Application;

interface EmployeeAPIInterface
{
    public function handle(object $command): void;
}
