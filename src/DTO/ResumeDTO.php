<?php

namespace App\DTO;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ResumeDTO
{
    private ?string $name = null;

    private ?DateTime $birthdate = null;
    private ?string $schoolGraduation = null;
    private ?string $trainingGraduation = null;

    private array $positions = [];

    private ?string $photo = null;

    private Collection $languages;

    private array $programmingLanguages = [];
    private array $tools = [];

    private Collection $projects;


    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(LanguageDTO $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
        }
        return $this;
    }

    public function removeLanguage(LanguageDTO $language): static
    {
        $this->languages->removeElement($language);
        return $this;
    }

    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(array $programmingLanguages): self
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function addProgrammingLanguage(?string $programmingLanguage): self
    {
        if (!in_array($programmingLanguage, $this->programmingLanguages, true)) {
            $this->programmingLanguages[] = $programmingLanguage;
        }

        return $this;
    }

    public function getTools(): array
    {
        return $this->tools;
    }

    public function setTools(array $tools): self
    {
        $this->tools = $tools;
        return $this;
    }

    public function addTool(?string $tool): self
    {
        if (!in_array($tool, $this->tools, true)) {
            $this->tools[] = $tool;
        }
        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(ProjectDTO $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(ProjectDTO $project): static
    {
        $this->projects->removeElement($project);

        return $this;
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


    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): self
    {
        $this->positions = $positions;
        return $this;
    }

    public function addPosition(?string $position): self
    {
        if (!in_array($position, $this->positions, true)) {
            $this->positions[] = $position;
        }
        return $this;
    }


    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBirthdate(): ?DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function getSchoolGraduation(): ?string
    {
        return $this->schoolGraduation;
    }

    public function setSchoolGraduation(?string $schoolGraduation): void
    {
        $this->schoolGraduation = $schoolGraduation;
    }

    public function getTrainingGraduation(): ?string
    {
        return $this->trainingGraduation;
    }

    public function setTrainingGraduation(?string $trainingGraduation): void
    {
        $this->trainingGraduation = $trainingGraduation;
    }
}
