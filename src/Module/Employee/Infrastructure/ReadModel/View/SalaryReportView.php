<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\ReadModel\View;

use App\Infrastructure\Infrastructure\Doctrine\TimestampableTrait;
use App\Module\Employee\Domain\Employee;
use App\Module\Employee\Domain\Entity\SalaryReportType;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="salary_report_view")
 */
final class SalaryReportView
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
     * @ORM\Column(type="string")
     */
    private string $path;

    /**
     * @ORM\Column(type="salary_report_type")
     */
    private SalaryReportType $type;

    /**
     * @ORM\ManyToOne(targetEntity="EmployeeView", inversedBy="workedDays")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private ?EmployeeView $employee;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): SalaryReportView
    {
        $this->id = $id;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): SalaryReportView
    {
        $this->path = $path;

        return $this;
    }

    public function getEmployee(): ?EmployeeView
    {
        return $this->employee;
    }

    /**
     * @param Employee|null $employee
     */
    public function setEmployee(?EmployeeView $employee): SalaryReportView
    {
        $this->employee = $employee;

        return $this;
    }

    public function getType(): SalaryReportType
    {
        return $this->type;
    }

    public function setType(SalaryReportType $type): SalaryReportView
    {
        $this->type = $type;

        return $this;
    }
}
