<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Game;

interface GameRepository
{
    public function create(Game $game, ?bool $flush = false): void;
}
