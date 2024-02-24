<?php

declare(strict_types=1);

namespace App\UseCase\GetGames;

use App\Domain\Entity\Team;

final class Request
{
    public function __construct(private readonly ?Team $team = null)
    {
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }
}
