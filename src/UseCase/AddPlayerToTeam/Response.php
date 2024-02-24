<?php

declare(strict_types=1);

namespace App\UseCase\AddPlayerToTeam;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;

class Response
{
    public function __construct(
        private readonly Team $team,
        private readonly Player $player
    ) {
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }
}
