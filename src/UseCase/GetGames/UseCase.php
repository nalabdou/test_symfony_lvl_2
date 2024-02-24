<?php

declare(strict_types=1);

namespace App\UseCase\GetGames;

use App\Domain\Repository\GameRepository;

final class UseCase
{
    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

    public function execute(Request $request): Response
    {
        return new Response($this->gameRepository->findToDisplay($request->getTeam()));
    }
}
