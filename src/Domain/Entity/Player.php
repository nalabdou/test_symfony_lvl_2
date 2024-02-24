<?php

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class Player implements \Stringable
{
    private Uuid $id;

    private string $name;

    private Collection $teams;

    /**
     * @throws ValidationException
     */
    public function __construct(Uuid $id, string $name, Collection $teams = new ArrayCollection())
    {
        $this->id = $id;
        if (mb_strlen($name) > 255) {
            throw new ValidationException('Name must have less than 255 characters.');
        }
        $this->name = $name;
        $this->teams = $teams;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): void
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }
    }

    public function removeTeam(Team $team): void
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
