<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\ValidationException;
use Symfony\Component\Uid\Uuid;

class Team
{
    /**
     * @throws ValidationException
     */
    public function __construct(private readonly Uuid $id, private readonly string $name)
    {
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
}
