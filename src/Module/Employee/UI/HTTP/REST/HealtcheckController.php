<?php

declare(strict_types=1);

namespace App\Module\Employee\UI\HTTP\REST;

use App\Module\Employee\Application\EmployeeAPIInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HealtcheckController extends AbstractController
{
    /**
     * @Route("/healtcheck", name="healtcheck", methods={"GET"})
     */
    public function getEmployees(): Response
    {
        return new Response(null);
    }
}
