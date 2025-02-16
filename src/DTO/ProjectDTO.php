<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class ProjectDTO
{
    private ?Ulid $id = null;

    private ?string $title = null;

    private ?int $year = null;

    private ?string $description = null;

    private array $technologies = [];

    private ?string $task = null;
    private ?string $workflow = null;

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

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(?string $task): void
    {
        $this->task = $task;
    }

    public function getWorkflow(): ?string
    {
        return $this->workflow;
    }

    public function setWorkflow(?string $workflow): void
    {
        $this->workflow = $workflow;
    }

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function setTechnologies(array $technologies): void
    {
        $this->technologies = $technologies;
    }

    public function addTechnology(?string $technology): self
    {
        if (!in_array($technology, $this->technologies, true)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

}
