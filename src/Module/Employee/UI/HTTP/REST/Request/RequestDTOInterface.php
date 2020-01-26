<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestDTOInterface
{
    public function __construct(Request $request);
}
