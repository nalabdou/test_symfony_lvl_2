<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Game;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\Collection;
use App\Domain\Exception\ValidationException;
use Doctrine\Common\Collections\ArrayCollection;

class Team implements \Stringable
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        private readonly Uuid $id,
        private readonly string $name,
        private Collection $players = new ArrayCollection(),
        private Collection $homeGames = new ArrayCollection(),
        private Collection $awayGames = new ArrayCollection(),
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

    public function getHomeGames(): Collection
    {
        return $this->homeGames;
    }

    public function addHomeGame(Game $homeGame): void
    {
        if (!$this->homeGames->contains($homeGame)) {
            $this->homeGames->add($homeGame);
        }
    }

    public function removeHomeGame(Game $homeGame): void
    {
        if ($this->homeGames->contains($homeGame)) {
            $this->homeGames->removeElement($homeGame);
        }
    }

    public function getAwayGames(): Collection
    {
        return $this->awayGames;
    }

    public function addAwayGame(Game $awayGame): void
    {
        if (!$this->awayGames->contains($awayGame)) {
            $this->awayGames->add($awayGame);
        }
    }

    public function removeAwayGame(Game $awayGame): void
    {
        if ($this->awayGames->contains($awayGame)) {
            $this->awayGames->removeElement($awayGame);
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
