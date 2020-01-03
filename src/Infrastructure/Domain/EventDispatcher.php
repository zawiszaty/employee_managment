<?php
declare(strict_types=1);


namespace App\Infrastructure\Domain;


interface EventDispatcher
{
    public function dispatch(Event $event): void;
}