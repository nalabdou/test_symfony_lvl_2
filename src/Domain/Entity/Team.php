<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class Team implements \Stringable
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        private readonly Uuid $id,
        private readonly string $name,
        private Collection $players = new ArrayCollection()
    ) {
        if (\mb_strlen($name) > 255) {
            throw new ValidationException("Name must have less than 255 characters.");
        }
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): void
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }
    }

    public function removePlayer(Player $player): void
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
