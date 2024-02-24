<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Team;

interface TeamRepository
{
    public function create(Team $player, ?bool $flush = false): void;
}
