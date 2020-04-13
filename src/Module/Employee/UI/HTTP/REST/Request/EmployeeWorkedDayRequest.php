<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class EmployeeWorkedDayRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("int")
     */
    private $hoursAmount;

    public function __construct(Request $request)
    {
        $this->hoursAmount = $request->get('hours_amount');
    }

    public function getHoursAmount()
    {
        return $this->hoursAmount;
    }
}
