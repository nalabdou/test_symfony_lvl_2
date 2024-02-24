<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Player;
use App\Domain\Entity\Team;

interface TeamRepository
{
    public function create(Team $team, ?bool $flush = false): void;

    /**
     * @return Team[]
     */
    public function findAll(): array;

    public function findToDisplay(): array;

    public function addPlayer(Team $team, Player $player, ?bool $flush = false): void;

    /**
     * @return Team[]
     */
    public function findAllWithout(array $teams): array;
}
