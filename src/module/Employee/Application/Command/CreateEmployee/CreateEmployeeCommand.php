<?php

declare(strict_types=1);


namespace App\module\Employee\Application\Command\CreateEmployee;


class CreateEmployeeCommand
{
    private string $firstName;

    private string $lastName;

    private string $address;

    private string $remunerationCalculationWay;

    private float $salary;

    public function __construct(
        string $firstName,
        string $lastName,
        string $address,
        string $remunerationCalculationWay,
        float $salary
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->remunerationCalculationWay = $remunerationCalculationWay;
        $this->salary = $salary;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getRemunerationCalculationWay(): string
    {
        return $this->remunerationCalculationWay;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }
}