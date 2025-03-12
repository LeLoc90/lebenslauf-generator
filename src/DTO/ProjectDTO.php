<?php

namespace App\DTO;

use Symfony\Component\Uid\Ulid;

class ProjectDTO
{
    protected ?Ulid $id = null;

    protected ?string $title = null;

    protected ?int $year = null;

    protected ?string $description = null;

    protected array $technologies = [];

    protected ?string $task = null;
    protected ?string $workflow = null;

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
