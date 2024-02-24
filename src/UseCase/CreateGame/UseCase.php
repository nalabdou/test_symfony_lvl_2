<?php

declare(strict_types=1);

namespace App\UseCase\CreateGame;

use App\Domain\Entity\Game;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\GameRepository;
use Symfony\Component\Uid\Uuid;

class UseCase
{
    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

    /**
     * @throws ValidationException
     */
    public function execute(Request $request): Response
    {
        $this->gameRepository->create($game = (new Game(Uuid::v4(), $request->getName(), $request->getHomeTeam(), $request->getAwayTeam())), true);
        return new Response($game->getId());
    }
}
