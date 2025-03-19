<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Service\IDService;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $ulid;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $technologies = [];

    #[ORM\Column(length: 255)]
    private ?string $task = null;

    #[ORM\Column(length: 255)]
    private ?string $workflow = null;

    #[ORM\ManyToOne(targetEntity: Resume::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(name: 'resume_ulid', referencedColumnName: 'ulid', onDelete: 'CASCADE')]
    private ?Resume $resume = null;

    public function __construct()
    {
        $this->ulid ??= IDService::MakeULID(new DateTime('now'));
    }

    public function getUlid(): string
    {
        return $this->ulid;
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

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

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function setTechnologies(array $technologies): static
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getWorkflow(): ?string
    {
        return $this->workflow;
    }

    public function setWorkflow(string $workflow): static
    {
        $this->workflow = $workflow;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): static
    {
        $this->resume = $resume;

        return $this;
    }
}
