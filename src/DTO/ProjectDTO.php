<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class ProjectDTO
{
    private ?Ulid $id = null;

    private ?string $title = null;

    private ?string $description = null;

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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
