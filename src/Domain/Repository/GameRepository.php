<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Game;
use App\Domain\Entity\Team;

interface GameRepository
{
    public function create(Game $game, ?bool $flush = false): void;

    /**
     * @return Game[]
     */
    public function findAll(): array;

    public function findToDisplay(?Team $team): array;
}
