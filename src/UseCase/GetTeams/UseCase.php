<?php

declare(strict_types=1);

namespace App\UseCase\GetTeams;

use App\Domain\Repository\TeamRepository;

final class UseCase
{
    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    public function execute(Request $request): Response
    {
        return new Response($this->teamRepository->findToDisplay());
    }
}
