<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class ProgrammingLanguageDTO
{
    private ?Ulid $id = null;

    private ?string $title = null;


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
}
