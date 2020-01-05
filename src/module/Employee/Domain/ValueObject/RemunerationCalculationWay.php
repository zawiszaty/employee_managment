<?php

declare(strict_types=1);

namespace App\module\Employee\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static RemunerationCalculationWay HOURLY()
 * @method static RemunerationCalculationWay MONTHLY()
 * @method static RemunerationCalculationWay MONTHLY_WITH_COMMISSION()
 */
final class RemunerationCalculationWay extends Enum
{
    private const HOURLY = 'hourly';
    private const MONTHLY = 'monthly';
    private const MONTHLY_WITH_COMMISSION = 'monthly_with_commission';
}
