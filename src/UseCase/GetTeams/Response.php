<?php

declare(strict_types=1);

namespace App\UseCase\GetTeams;

use App\Domain\Entity\Team;

final class Response
{
    public function __construct(private readonly array $teams)
    {
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}
