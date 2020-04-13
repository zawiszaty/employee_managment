<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Command;

use App\Infrastructure\Infrastructure\Rabbit\Consumer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsumerCommand extends Command
{
    protected static $defaultName = 'app:consumers';

    private Consumer $consumer;

    private AMQPStreamConnection $connection;

    private string $exchange;
    /**
     * @var string
     */
    private string $locale;

    public function __construct(Consumer $consumer, AMQPStreamConnection $connection, string $exchange, string $locale)
    {
        parent::__construct();
        $this->consumer   = $consumer;
        $this->connection = $connection;
        $this->exchange   = $exchange;
        $this->locale     = $locale;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $chanel = $this->connection->channel();
        $output->write("[x] Creating exchange\n");
        $chanel->exchange_declare($this->exchange, 'fanout', false, false, false);
        $output->write("[x] Creating queue\n");
        $output->write("[x] Consuming:\n");
        $chanel->queue_declare(sprintf('%s.monolith', $this->locale), false, false, false, false);
        $this->consumer->consume();

        $chanel->close();
        $this->connection->close();

        return 0;
    }
}