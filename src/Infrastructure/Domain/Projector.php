<?php
declare(strict_types=1);


namespace App\Infrastructure\Domain;


interface Projector
{
    public function project(Event $event): void;
}