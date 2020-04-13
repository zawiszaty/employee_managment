<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class GenerateSalaryReportSingleEmployeeRequest implements RequestDTOInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("int")
     */
    private $month;

    public function __construct(Request $request)
    {
        $this->month = (int) $request->get('month');
    }

    public function getMonth(): int
    {
        return $this->month;
    }
}
