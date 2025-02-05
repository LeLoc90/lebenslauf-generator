<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class CompetenceDTO
{
    private ?Ulid $id = null;

    private ?string $title = null;

    private ?string $type = null;


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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
