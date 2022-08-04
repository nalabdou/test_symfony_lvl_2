<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Player;

interface PlayerRepository
{
    public function create(Player $player): void;
}