<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use MyCLabs\Enum\Enum;

/**
 * @method static SalaryReportType SINGLE_EMPLOYEE()
 * @method static SalaryReportType ALL_EMPLOYEE()
 */
final class SalaryReportType extends Enum
{
    private const SINGLE_EMPLOYEE = 'single_employee';
    private const ALL_EMPLOYEE = 'all_employee';
}
