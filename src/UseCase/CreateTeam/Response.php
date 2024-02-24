<?php

declare(strict_types=1);

namespace App\UseCase\CreateTeam;

use Symfony\Component\Uid\Uuid;

class Response
{
    public function __construct(private readonly Uuid $id)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
