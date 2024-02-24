<?php

declare(strict_types=1);

namespace App\UseCase\CreateTeam;

use App\Domain\Entity\Team;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\TeamRepository;
use Symfony\Component\Uid\Uuid;

class UseCase
{
    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws ValidationException
     */
    public function execute(Request $request): Response
    {
        $this->teamRepository->create($team = (new Team(Uuid::v4(), $request->getName())), true);

        return new Response($team->getId());
    }
}
