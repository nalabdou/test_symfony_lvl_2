<?php

namespace App\UseCase\CreatePlayer;

final class Request
{
    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
