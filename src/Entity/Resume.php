<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private ?Ulid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $schoolGraduation = null;

    #[ORM\Column(length: 255)]
    private ?string $trainingGraduation = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $positions = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $languages = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $programmingLanguages = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $tools = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $projects = [];

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthdate(): ?DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getSchoolGraduation(): ?string
    {
        return $this->schoolGraduation;
    }

    public function setSchoolGraduation(string $schoolGraduation): static
    {
        $this->schoolGraduation = $schoolGraduation;

        return $this;
    }

    public function getTrainingGraduation(): ?string
    {
        return $this->trainingGraduation;
    }

    public function setTrainingGraduation(string $trainingGraduation): static
    {
        $this->trainingGraduation = $trainingGraduation;

        return $this;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): static
    {
        $this->positions = $positions;

        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(array $programmingLanguages): static
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function getTools(): array
    {
        return $this->tools;
    }

    public function setTools(array $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): static
    {
        $this->projects = $projects;

        return $this;
    }
}
