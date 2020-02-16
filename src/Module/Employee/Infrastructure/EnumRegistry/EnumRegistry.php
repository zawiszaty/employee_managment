<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\EnumRegistry;

use Acelaya\Doctrine\Type\PhpEnumType;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;

final class EnumRegistry
{
    public static function register(): void
    {
        if (false === PhpEnumType::hasType('remuneration_calculation_way'))
        {
            PhpEnumType::registerEnumType('remuneration_calculation_way', RemunerationCalculationWay::class);
        }

        if (false === PhpEnumType::hasType('salary_report_type'))
        {
            PhpEnumType::registerEnumType('salary_report_type', SalaryReportType::class);
        }
    }
}
