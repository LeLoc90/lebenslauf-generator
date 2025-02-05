<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class TaskDTO
{
    private ?Ulid $id = null;

    private ?string $description = null;

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
