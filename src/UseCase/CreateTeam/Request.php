<?php

declare(strict_types=1);

namespace App\UseCase\CreateTeam;

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
