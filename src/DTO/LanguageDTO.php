<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class LanguageDTO
{
    protected ?Ulid $id = null;

    protected ?string $title = null;

    protected ?int $level = null;


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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

}
