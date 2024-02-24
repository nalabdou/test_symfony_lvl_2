<?php

declare(strict_types=1);

namespace App\UseCase\GetGames;

use App\Domain\Entity\Game;

final class Response
{
    public function __construct(private readonly array $games)
    {
    }

    /**
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->games;
    }
}
