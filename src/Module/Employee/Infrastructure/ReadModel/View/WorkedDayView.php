<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\ReadModel\View;

use App\Infrastructure\Infrastructure\Doctrine\TimestampableTrait;
use App\Module\Employee\Domain\Employee;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="worked_day_view")
 */
final class WorkedDayView
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\ManyToOne(targetEntity="EmployeeView", inversedBy="workedDays")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private EmployeeView $employee;

    /**
     * @ORM\Column(type="integer")
     */
    private int $hoursAmount;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeImmutable $day;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): WorkedDayView
    {
        $this->id = $id;

        return $this;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    public function setEmployee(EmployeeView $employee): WorkedDayView
    {
        $this->employee = $employee;

        return $this;
    }

    public function getHoursAmount(): int
    {
        return $this->hoursAmount;
    }

    public function setHoursAmount(int $hoursAmount): WorkedDayView
    {
        $this->hoursAmount = $hoursAmount;

        return $this;
    }

    public function getDay(): \DateTimeImmutable
    {
        return $this->day;
    }

    public function setDay(\DateTimeImmutable $day): WorkedDayView
    {
        $this->day = $day;

        return $this;
    }
}
