<?php

declare(strict_types=1);


namespace App\module\Employee\Application;

use App\Infrastructure\Application\CommandBus;

class EmployeeApi extends CommandBus implements EmployeeAPIInterface
{
}