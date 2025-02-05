<?php

namespace App\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ResumeDTO
{
    private ?string $introduction = null;

    private ?string $firstname = null;

    private ?string $lastname = null;

    private ?string $position = null;

    private ?string $photo = null;

    private Collection $languages;

    private Collection $educations;

    private Collection $programmingLanguages;

    private Collection $tasks;

    private Collection $competences;

    private Collection $projects;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->educations = new ArrayCollection();
        $this->programmingLanguages = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
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

    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(EducationDTO $education): static
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
        }
        return $this;
    }

    public function removeEducation(EducationDTO $education): static
    {
        $this->educations->removeElement($education);
        return $this;
    }

    public function getProgrammingLanguages(): Collection
    {
        return $this->programmingLanguages;
    }

    public function addProgrammingLanguage(ProgrammingLanguageDTO $programmingLanguage): static
    {
        if (!$this->programmingLanguages->contains($programmingLanguage)) {
            $this->programmingLanguages->add($programmingLanguage);
        }

        return $this;
    }

    public function removeProgrammingLanguage(ProgrammingLanguageDTO $programmingLanguage): static
    {
        $this->programmingLanguages->removeElement($programmingLanguage);

        return $this;
    }


    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(TaskDTO $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }

        return $this;
    }

    public function removeTask(TaskDTO $task): static
    {
        $this->tasks->removeElement($task);
        return $this;
    }

    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(CompetenceDTO $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }

        return $this;
    }

    public function removeCompetence(CompetenceDTO $competence): static
    {
        $this->competences->removeElement($competence);

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

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
}
