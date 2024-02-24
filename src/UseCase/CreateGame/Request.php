<?php

declare(strict_types=1);

namespace App\UseCase\CreateGame;

use App\Domain\Entity\Team;

final class Request
{
    public function __construct(
        private readonly string $name,
        private readonly Team $homeTeam,
        private readonly Team $awayTeam
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }
}
