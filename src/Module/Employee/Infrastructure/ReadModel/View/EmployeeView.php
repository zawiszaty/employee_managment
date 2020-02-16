<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\ReadModel\View;

use App\Infrastructure\Infrastructure\Doctrine\TimestampableTrait;
use App\Module\Employee\Domain\ValueObject\RemunerationCalculationWay;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="employee_view")
 */
final class EmployeeView
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private string $address;

    /**
     * @ORM\Column(type="remuneration_calculation_way")
     */
    private RemunerationCalculationWay $remunerationCalculationWay;

    /**
     * @ORM\Column(type="float")
     */
    private float $salary;

    /**
     * @ORM\Column(type="float")
     */
    private float $commissions;

    /**
     * @ORM\OneToMany(targetEntity="WorkedDayView", mappedBy="employee")
     */
    private Collection $workedDays;

    /**
     * @ORM\OneToMany(targetEntity="SalaryReportView", mappedBy="employee")
     */
    private Collection $salaryReports;

    public function __construct()
    {
        $this->workedDays = new ArrayCollection();
        $this->salaryReports = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): EmployeeView
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): EmployeeView
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): EmployeeView
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): EmployeeView
    {
        $this->address = $address;

        return $this;
    }

    public function getRemunerationCalculationWay(): RemunerationCalculationWay
    {
        return $this->remunerationCalculationWay;
    }

    public function setRemunerationCalculationWay(RemunerationCalculationWay $remunerationCalculationWay): EmployeeView
    {
        $this->remunerationCalculationWay = $remunerationCalculationWay;

        return $this;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): EmployeeView
    {
        $this->salary = $salary;

        return $this;
    }

    public function getCommissions(): float
    {
        return $this->commissions;
    }

    public function setCommissions(float $commissions): EmployeeView
    {
        $this->commissions = $commissions;

        return $this;
    }

    public function getWorkedDays(): Collection
    {
        return $this->workedDays;
    }

    public function setWorkedDays(Collection $workedDays): EmployeeView
    {
        $this->workedDays = $workedDays;

        return $this;
    }

    public function getSalaryReports(): Collection
    {
        return $this->salaryReports;
    }

    public function setSalaryReports(Collection $salaryReports): EmployeeView
    {
        $this->salaryReports = $salaryReports;

        return $this;
    }
}
