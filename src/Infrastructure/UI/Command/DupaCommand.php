<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Command;

use App\Infrastructure\Infrastructure\Rabbit\Producer;
use App\Module\Employee\Application\Command\CreateEmployee\CreateEmployeeCommand;
use App\Module\Employee\Application\EmployeeAPIInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DupaCommand extends Command
{
    protected static $defaultName = 'dupa:dupa';

    private Producer $producer;
    /**
     * @var EmployeeAPIInterface
     */
    private EmployeeAPIInterface $employeeAPI;

    public function __construct(Producer $producer, EmployeeAPIInterface $employeeAPI)
    {
        parent::__construct();
        $this->producer    = $producer;
        $this->employeeAPI = $employeeAPI;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->employeeAPI->handle(new CreateEmployeeCommand(
//            'test',
//            'test',
//            'test',
//            'hourly',
//            200.0
//        ));
//        $event = new ProductSaleEvent(
//            EventId::generate(),
//            AggregateRootId::generate(),
//            200.0
//        );
//        $this->producer->produce($event);

        return 0;
    }
}