<?php

declare(strict_types=1);

namespace App\UseCase\AddPlayerToTeam;

use App\Domain\Exception\ValidationException;
use App\Infrastructure\Doctrine\Repository\TeamRepository;

class UseCase
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
    ) {
    }

    public function execute(Request $request): Response
    {
        $this->teamRepository->addPlayer($team = $request->getTeam(), $player = $request->getPlayer(), true);
        return new Response($team, $player);
    }
}
