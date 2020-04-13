<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateEmployeeRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $address;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Choice({"hourly", "monthly", "monthly_with_commission"})
     */
    private $remunerationCalculationWay;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("float")
     */
    private $salary;

    public function __construct(Request $request)
    {
        $this->firstName = $request->get('first_name');
        $this->lastName = $request->get('last_name');
        $this->address = $request->get('address');
        $this->remunerationCalculationWay = $request->get('remuneration_calculation_way');
        $this->salary = (float) $request->get('salary');
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
