<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\ValueObject;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Assertion\Assertion;
use App\Infrastructure\Domain\Clock;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Commission
{
    private UuidInterface $uuid;

    private float $commission;

    private AggregateRootId $employeeId;

    private Clock $month;

    private function __construct(UuidInterface $uuid, AggregateRootId $employeeId, float $commissionValue, Clock $month)
    {
        $this->commission = $commissionValue;
        $this->uuid = $uuid;
        $this->employeeId = $employeeId;
        $this->month = $month;
    }

    public static function create(float $commissionValue, AggregateRootId $employeeId, Clock $month): self
    {
        Assertion::greaterThan($commissionValue, 0);

        return new static(Uuid::uuid4(), $employeeId, $commissionValue, $month);
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getEmployeeId(): AggregateRootId
    {
        return $this->employeeId;
    }

    public function getMonth(): Clock
    {
        return $this->month;
    }
}
