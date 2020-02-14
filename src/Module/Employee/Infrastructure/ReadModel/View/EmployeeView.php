<?php

declare(strict_types=1);

namespace App\Module\Employee\Infrastructure\ReadModel\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="employee_view")
 */
final class EmployeeView
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private string $id;

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
     * @ORM\Column(type="string")
     */
    private string $remunerationCalculationWay;

    /**
     * @ORM\Column(type="string")
     */
    private float $salary;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): EmployeeView
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

    public function getRemunerationCalculationWay(): string
    {
        return $this->remunerationCalculationWay;
    }

    public function setRemunerationCalculationWay(string $remunerationCalculationWay): EmployeeView
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
}
