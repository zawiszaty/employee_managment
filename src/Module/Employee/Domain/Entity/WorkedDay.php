<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Entity;

use App\Infrastructure\Domain\AggregateRootId;
use App\Infrastructure\Domain\Assertion\Assertion;
use App\Infrastructure\Domain\Clock;
use App\Infrastructure\Domain\Uuid;

final class WorkedDay
{
    private Uuid $id;

    private int $hoursAmount;

    private Clock $day;

    private AggregateRootId $employeeId;

    private function __construct(
        Uuid $id,
        Clock $clock,
        int $hoursAmount,
        AggregateRootId $employeeId
    ) {
        $this->id = $id;
        $this->hoursAmount = $hoursAmount;
        $this->day = $clock;
        $this->employeeId = $employeeId;
    }

    public static function create(int $hoursAmount, Clock $clock, AggregateRootId $employeeId): self
    {
        Assertion::greaterThan($hoursAmount, -1);
        Assertion::lessThan($hoursAmount, 25);

        return new static(Uuid::generate(), $clock, $hoursAmount, $employeeId);
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function getDay(): Clock
    {
        return $this->day;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmployeeId(): AggregateRootId
    {
        return $this->employeeId;
    }
}
