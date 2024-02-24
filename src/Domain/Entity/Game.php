<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Symfony\Component\Uid\Uuid;

/**
 * Match is PHP reserved word.
 */
class Game implements \Stringable
{
    public function __construct(
        private readonly Uuid $id,
        private readonly string $name,
        private readonly Team $homeTeam,
        private readonly Team $awayTeam
    ) {
        if (\mb_strlen($name) > 255) {
            throw new ValidationException('Name must have less than 255 characters.');
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
